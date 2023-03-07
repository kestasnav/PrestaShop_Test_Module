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
        /** API form */
        $fields_form = array(
            'form' => array(
                'legend' => [
                    'title' => $this->l('API'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('API URL'),
                        'name' => 'API_URL',
                        'size' => 20,
                        'required' => true,
                    ]
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                ],
            ));

        /** Customers form */
        $fields_form1 = array(
            'form' => array(
                'legend' => [
                    'title' => $this->l('Customers'),
                ],
                'input' => [
                    [
                        'label' => $this->l('Create random customers to database'),
                        'query' => $this->createCustomer($this->getRandomFirstName(), $this->getRandomLastName(), $this->getRandomEmail()),
                    ]
                ],
                'submit' => [
                    'title' => $this->l('Create'),
                    'name' => 'submitForm',
                    'class' => 'btn btn-default pull-right'
                ],
            ));

        $output = null;

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->fields_value['API_URL'] = Tools::getValue('API_URL', Configuration::get('API_URL'));
        $output .= $helper->generateForm(array($fields_form, $fields_form1));

        if (!Tools::isSubmit('submitMyForm')) {
            $output .= $this->displayConfirmation($this->l('Customer created'));
        }

        /** Save products and categories to database from API */
        $json = file_get_contents(Tools::getValue('API_URL', Configuration::get('API_URL')));

        if ($json) {
            $response_data = json_decode($json, true);
            $output .= $this->displayConfirmation($this->l('API updated'));
        } else {
            $output .= $this->displayError($this->l('Invalid API URL'));
        }

        $count = 0;
            foreach ($response_data as $data) {

                if ($count >= 5) {
                    break;
                }

                if (empty($data['title'])) {
                    $output .= $this->displayError($this->l('Product title is empty'));
                } else {
                            $category = new Category();
                            $category->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $data['category']);
                            $category->link_rewrite = array((int)Configuration::get('PS_LANG_DEFAULT') => 'new');
                            $category->active = 1;
                            $category->id_parent = 2;
                            try {
                                (!$category->add());
                                $output .= $this->displayConfirmation($this->l('Kategorija ' . $category->id . ' pridėta sėkmingai'));
                            } catch (Exception $e) {
                                $output .= $this->displayError($this->l('Problema kuriant kategoriją (' . $e->getMessage() . ')', "\n"));
                            }

                    $product = new Product();
                    $product->name = array((int)Configuration::get('PS_LANG_DEFAULT') => $data['title']);
                    $product->description = array((int)Configuration::get('PS_LANG_DEFAULT') => $data['description']);
                    $product->price = (float)$data['price'];
                    $product->quantity = (float)$data['count'];
                    $product->id_category_default = $category->id;
                    $count++;
                    try {
                        (!$product->add());
                        $output .= $this->displayConfirmation($this->l('Produktas ' . $product->id . ' pridėtas sėkmingai'));
                    } catch (Exception $e) {
                        $output .= $this->displayError($this->l('Problema kuriant produktą (' . $e->getMessage() . ')', "\n"));
                    }
                }
            }
        return $output;
    }

    public function postProcess()
    {
        if (Tools::isSubmit('submit'.$this->name)) {
            $api_url = Configuration::get('API_URL');
            if (!$api_url || empty($api_url)) {
                return;
            }
            $updated_url = str_replace('https://fakestoreapi.com/products', $api_url, Configuration::get('API_URL'));
            Configuration::updateValue('API_URL', $updated_url);
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

