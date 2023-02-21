<?php
# /modules/testmodule/testmodule.php

/**
 * Test Module - A Prestashop Module
 * 
 * Technical Task
 * 
 * @author kestasnav <kestasnav@gmail.com>
 * @version 0.0.1
 */

if (!defined('_PS_VERSION_')) exit;

class TestModule extends Module
{
	const DEFAULT_CONFIGURATION = [
		// Put your default configuration here, e.g :
		// 'TESTMODULE_BACKGROUND_COLOR' => '#eee',
	];

	public function __construct()
	{
		$this->initializeModule();
	}

	public function install()
	{
		return
			parent::install()
			&& $this->initDefaultConfigurationValues()
            && $this->createCustomer($this->getRandomFirstName(),$this->getRandomLastName(),$this->getRandomEmail())
            && $this->generateNewCategory()
            && $this->generateNewProducts()
		;
	}


    public function uninstall()
	{
		return
			parent::uninstall()
            && $this->createCustomer($this->getRandomFirstName(),$this->getRandomLastName(),$this->getRandomEmail())
            && $this->generateNewCategory()
            && $this->generateNewProducts()
		;
	}

    /** Module configuration page */
    public function getContent()
    {
        $output = null;

        // Išsaugo logą po produkto kūrimo
        $newProduct = new Product();
        $newProduct->name = "New Product";

        if (!$newProduct->save()) {
            $logger = new PrestaShopLogger();
            $logger->addLog(
                'Failed to create product',
                1,
                null,
                'TestModule',
                (int) $newProduct->id_shop_default,
                true
            );
             $output.= $this->displayError('Failed to create product');
        }
             $output.= $this->displayConfirmation('Product created successfully');

        // Išsaugo logą, jeigu kategorijos pavadinimo nėra
        if (empty($category->name)) {
            PrestaShopLogger::addLog('Category name is empty', 2, null, null, null, true);
            $output .= $this->displayError('Category name is required.');
        }

        if (Tools::isSubmit('submit'.$this->name)) {
            $api_url = strval(Tools::getValue('API_URL'));
            if (!$api_url || empty($api_url)) {
                PrestaShopLogger::addLog('Invalid API URL', 3, null, 'TestModule', null, true);
                $output .= $this->displayError($this->l('Invalid API URL'));
            } else {
                Configuration::updateValue('API_URL', $api_url);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        $fields_form =  array(
            'form' => array(
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('API URL'),
                    'name' => 'API_URL',
                    'size' => 20,
                    'required' => true,
                    'value' => Configuration::get('EXAMPLE_API_URL')
                ]
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ],
            )
            );


        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->fields_value['API_URL'] = Configuration::get('API_URL');
        $output .= $helper->generateForm(array($fields_form));

        return $output;
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submit'.$this->name)) {
            $api_url = Configuration::get('API_URL');
            if (!$api_url || empty($api_url)) {
                return;
            }
            $updated_url = str_replace('https://fakestoreapi.com/', $api_url, Configuration::get('EXAMPLE_API_URL'));
            Configuration::updateValue('EXAMPLE_API_URL', $updated_url);
        }
    }

	/** Initialize the module declaration */
	private function initializeModule()
	{
		$this->name = 'testmodule';
		$this->tab = 'others';
		$this->version = '0.0.1';
		$this->author = 'kestasnav';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = [
			'min' => '1.6',
			'max' => _PS_VERSION_,
		];
		$this->bootstrap = true;
		
		parent::__construct();

		$this->displayName = $this->l('Test Module');
		$this->description = $this->l('Technical Task');
		$this->confirmUninstall = $this->l('Are you sure you want to uninstall this module ?');
	}

	/** Set module default configuration into database */
	private function initDefaultConfigurationValues()
	{
		foreach (self::DEFAULT_CONFIGURATION as $key => $value) {
			if (!Configuration::get($key)) {
				Configuration::updateValue($key, $value);
			}
		}

		return true;
	}

    /** Generate new product category */
    public function generateNewCategory()
    {
        try {
            $category_names = array('Kompiuteriai', 'Telefonai', 'Televizoriai');
            foreach ($category_names as $category_name) {
                $category = new Category();
                $category->name = array('1' => $category_name);
                $category->description = 'Nauja kategorija ';
                $category->link_rewrite = array('1' => $category_name);
                $category->active = 1;
                $category->id_parent = 2;
                if (!$category->add()) {
                    throw new Exception('Nepavyko sukurti kategorijos'); // Jei nepavyko sukurti kategorijos, išmes klaidos pranešimą
                }
                echo 'Kategorija sėkmingai sukurta su ID: ' . $category->id; // Jei viskas sėkmingai, rodomas pranešimas su kategorijos ID
            }
        }
        catch (Exception $e) {
                // Jei atsirado klaida, išmes klaidos pranešimą vartotojui
                echo 'Klaida: ' . $e->getMessage();
            }
            return $category;
        }

    /** Generate new products */
    public function generateNewProducts() {
        try {
        $product_data = array(
            array(
                'name' => 'Dell Inspiron 15',
                'description' => 'Galingas nešiojamas kompiuteris',
                'price' => 799.99,
            ),
            array(
                'name' => 'iPhone 12 Pro',
                'description' => 'Naujausias Apple išmanusis telefonas',
                'price' => 1199.99,
            ),
            array(
                'name' => 'Samsung QLED TV',
                'description' => 'Aukščiausios klasės QLED televizorius',
                'price' => 1999.99,
            ),
        );

        foreach ($product_data as $data) {
            $product = new Product();
            $product->name = array('1' => $data['name']);
            $product->description = array('1' => $data['description']);
            $product->price = $data['price'];
            $product->id_category_default = 2;
            if (!$product->add()) {
                throw new Exception('Nepavyko sukurti produkto'); // Jei nepavyko sukurti produkto, išmes klaidos pranešimą
            }
            echo 'Produktas sėkmingai sukurtas su ID: ' . $product->id; // Jei viskas sėkmingai, rodomas pranešimas su produkto ID
        }
        } catch (Exception $e) {
            // Jei atsirado klaida, išmes klaidos pranešimą vartotojui
            echo 'Klaida: ' . $e->getMessage();
        }
        return $product;
    }

    /** Generate random Customers */
    public function createCustomer($name, $surname, $email) {
        try {
        $customer = new Customer();
        $customer->firstname = $name;
        $customer->lastname = $surname;
        $customer->email = $email;
        $customer->active = true;
        $customer->is_guest = false;
        $customer->passwd = Tools::hash('mypassword');
            if (!$customer->add()) {
                throw new Exception('Nepavyko sukurti vartotojo'); // Jei nepavyko sukurti vartotojo, išmes klaidos pranešimą
            }
            echo 'Vartotojas sėkmingai sukurtas su ID: ' . $customer->id; // Jei viskas sėkmingai, rodomas pranešimas su vartotojo ID
        }
        catch (Exception $e) {
        // Jei atsirado klaida, išmes klaidos pranešimą vartotojui
            echo 'Klaida: ' . $e->getMessage();
        }
        return $customer;
    }

    /** Generate random customer name */
    private function getRandomFirstName() {
        $firstnames = ['Jonas', 'Petras', 'Antanas', 'Vardenis', 'Algirdas'];
        return $firstnames[array_rand($firstnames)];
    }

    /** Generate random customer surname */
    private function getRandomLastName() {
        $lastnames = ['Jonaitis', 'Petraitis', 'Antanaitis', 'Pavardenis', 'Algirdaitis'];
        return $lastnames[array_rand($lastnames)];
    }

    /** Generate random customer email */
    private function getRandomEmail() {
        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com'];
        $name = strtolower($this->getRandomFirstName() . '.' . $this->getRandomLastName());
        $domain = $domains[array_rand($domains)];
        return $name . '@' . $domain;
    }
}

