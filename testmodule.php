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
//            && $this->generateNewCategory()
//            && $this->generateNewProducts()
//            && $this->registerHook('displayHeader')
//            && $this->generateRandomCustomers(5)
		;
	}

	public function uninstall()
	{
		return
			parent::uninstall()
//            && $this->generateNewCategory()
//            && $this->generateNewProducts()
//            && $this->unregisterHook('displayHeader')
//            && $this->generateRandomCustomers(5)
		;
	}

	/** Module configuration page */
//	public function getContent()
//	{
//        $url = 'https://fakestoreapi.com/';
//        $data = Tools::file_get_contents($url);
//        $json_data = json_decode($data, true);
//	}
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

        $fields_form = [
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
            ]
        ];

        $helper = new HelperForm();
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
        $helper->default_form_language = (int)Configuration::get('PS_LANG_DEFAULT');
        $helper->allow_employee_form_lang = $helper->default_form_language;
        $helper->title = $this->displayName;
        $helper->submit_action = 'submit'.$this->name;

        // Load current value
        $helper->fields_value['API_URL'] = Configuration::get('API_URL');

        return $output.$helper->generateForm([$fields_form]);
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

    public function hookDisplayHeader()
    {
        // Add JS file to header
        $this->context->controller->addJS(Configuration::get('EXAMPLE_API_URL'));
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
//    public function generateNewCategory() {
//
////        $categories = Category::getCategories($id_lang = false, $active = true, $order = 'position');
//
////        foreach ($categories as $category) {
//            $new_category = new Category();
//            $new_category->id_parent = 1;
//            $new_category->active = true;
//            $new_category->name = 'Nauja kategorija ' . 1;
//            $new_category->link_rewrite = 'nauja-kategorija-' . 1;
//            $new_category->add();
////        }
//    }
//
//    /** Generate new products */
//    public function generateNewProducts() {
//        for ($i = 1; $i <= 5; $i++) {
//            $product = new Product();
//            $product->name = array('en' => 'Product ' . $i, 'lt' => 'Produktas ' . $i);
//            $product->description = array('en' => 'Description of product ' . $i, 'lt' => 'Produkto ' . $i . ' aprašymas');
//            $product->price = 19.99;
//            $product->quantity = 100;
//            $product->id_category = 2;
//            $product->add();
//        }
//    }
//
//    /** Generate random Customers */
//    public function generateRandomCustomers($count) {
//        for ($i = 0; $i < $count; $i++) {
//            $customer = new Customer();
//            $customer->firstname = $this->getRandomFirstName();
//            $customer->lastname = $this->getRandomLastName();
//            $customer->email = $this->getRandomEmail();
//            $customer->add();
//        }
//    }
//
//    /** Generate random customer name */
//    private function getRandomFirstName() {
//        $firstnames = ['Jonas', 'Petras', 'Antanas', 'Vardenis', 'Algirdas'];
//        return $firstnames[array_rand($firstnames)];
//    }
//
//    /** Generate random customer surname */
//    private function getRandomLastName() {
//        $lastnames = ['Jonaitis', 'Petraitis', 'Antanaitis', 'Pavardenis', 'Algirdaitis'];
//        return $lastnames[array_rand($lastnames)];
//    }
//
//    /** Generate random customer email */
//    private function getRandomEmail() {
//        $domains = ['gmail.com', 'yahoo.com', 'hotmail.com'];
//        $name = strtolower($this->getRandomFirstName() . '.' . $this->getRandomLastName());
//        $domain = $domains[array_rand($domains)];
//        return $name . '@' . $domain;
//    }
}

