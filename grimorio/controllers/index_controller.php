<?php
/**
 */
class IndexController extends AppController
{
	#
	protected function before_filter()
	{
        if ( $action = Input::post('hechizos') )
        {
            unset($_POST['hechizos']);
            $this->item = (new Hechizos)->$action($_POST);
        }
    }

	#
    public function index($id=0)
    {
		$this->last_created = (new Hechizos)->ultimos();

        $this->items = (new Hechizos)->todos();

		if ( ! $this->item )
        	$this->item = (new Hechizos)->unoPorId($id);

		if ($id>0 and ! $this->item)
		{
			header("HTTP/2.0 404 Not Found");
			die('Pa ti un 404 y un sapito: ' . PHP_SAPI);
		}
    }

	#
    public function formulario()
    {
		if ( ! Input::isAjax() ) exit( Redirect::to('') );
		$this->metadata = (new Hechizos)->metadata();
		View::setPath('hechizos');
    }

    /*public function eliminar($id)
    {
		(new Hechizos)->delete($id);
		Redirect::to();
		exit;
    }*/
}
