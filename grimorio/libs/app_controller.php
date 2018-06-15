<?php
require_once CORE_PATH . 'kumbia/controller.php';
/**
 */
class AppController extends Controller
{
    final protected function initialize()
    {
        if ( Input::isAjax() ) View::template('');
    }

    final protected function finalize()
    {

    }
}
