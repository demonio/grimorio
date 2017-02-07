<?php
/**
 */
class IndexController extends AppController
{    #
	protected function before_filter()
	{
        if ( $action = Input::post('hechizos') )
        {
            unset($_POST['hechizos']);
            $this->item = (new Hechizos)->$action($_POST);
        }
    }

    public function index($id=0)
    {
        $this->items = (new Hechizos)->todos();

		if ( ! $this->item )
        	$this->item = (new Hechizos)->rowOrCols($id);
    }

    public function formulario($id=0)
    {
		if ( ! Input::isAjax() ) exit;
		$this->metadata = (new Hechizos)->metadata();
        $this->item = ($id) ? (new Hechizos)->first($id) : '';
    }

    /*public function eliminar($id)
    {
		(new Hechizos)->delete($id);
		Redirect::to();
		exit;
    }*/
}
