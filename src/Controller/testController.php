<?php

namespace testmodule\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class  testController extends FrameworkBundleAdminController {

    public function testAction() {
        return 'hi';
    }

}