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
		;
	}

    /** Module configuration page */
    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            $api_url = strval(Tools::getValue('API_URL'));
            if (!$api_url || empty($api_url)) {
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
                    'required' => true
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

            $updated_url = str_replace('http://example.com/api', $api_url, Configuration::get('EXAMPLE_API_URL'));
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
    public function generateNewCategory() {
        $category_names = array('Kompiuteriai', 'Telefonai', 'Televizoriai');
        foreach ($category_names as $category_name) {
            $category = new Category();
            $category->name = array('1' => $category_name);
            $category->description = 'Nauja kategorija ';
            $category->link_rewrite = array('1' => $category_name);
            $category->active = 1;
            $category->id_parent = 2;
            $category->add();
        }
        return $category;
    }

    /** Generate new products */
    public function generateNewProducts() {
        $product_data = array(
            array(
                'name' => 'Dell Inspiron 15',
                'description' => 'Galingas nešiojamas kompiuteris su Core i7 procesoriumi',
                'price' => 799.99,
            ),
            array(
                'name' => 'iPhone 12 Pro',
                'description' => 'Naujausias Apple išmanusis telefonas su 5G technologija',
                'price' => 1199.99,
            ),
            array(
                'name' => 'Samsung QLED TV',
                'description' => 'Aukščiausios klasės QLED televizorius su 4K UHD vaizdu',
                'price' => 1999.99,
            ),
        );

        foreach ($product_data as $data) {
            $product = new Product();
            $product->name = array('1' => $data['name']);
            $product->description = array('1' => $data['description']);
            $product->price = $data['price'];
            $product->id_category_default = 2;
            $product->add();
        }

        return $product;
    }

    /** Generate random Customers */
    public function createCustomer($name, $surname, $email) {
        $customer = new Customer();
        $customer->firstname = $name;
        $customer->lastname = $surname;
        $customer->email = $email;
        $customer->active = true;
        $customer->is_guest = false;
        $customer->passwd = Tools::hash('mypassword');
        $customer->add();
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

