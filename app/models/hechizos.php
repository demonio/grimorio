<?php
/**
 */
class Hechizos extends ActRecord
{
    #
    public function todos()
    {
        $items = (new Hechizos)->all();
        foreach ($items as $item)
        {
            $a[$item->grimorio][] = $item;
        }
        return $a;
    }

    #
    public function crear($a)
    {
        return $this->create($a);
    }

    #
    public function editar($a)
    {
        return $this->update($a);
    }

    #
    public function eliminar($a)
    {
        return $this->delete($a['id']);
    }
}
