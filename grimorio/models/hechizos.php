<?php
/**
 */
class Hechizos extends ActRecord
{
    #
    public function unoPorId($id)
    {
        $item = $this
            ->where('estado<>? AND id=?', ['[BORRADO]', $id])
            ->first();
        $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
        return $item;
    }

    #
    public function unoPorSlug($slug)
    {
        $slugforbd = _::slug($slug, '%');
        $item = $this
            ->where('estado<>? AND CONCAT(grimorio, capitulo, nombre) LIKE ?', ['[BORRADO]', "%$slugforbd%"])
            ->first();
        $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
        return $item;
    }

    #
    public function todos()
    {
        $items = $this
            ->where('estado<>?', '[BORRADO]')
            ->order('grimorio, nombre')
            ->all();
        foreach ($items as $item)
        {
            $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
            $a[$item->grimorio][] = $item;
        }
        return $a;
    }

    #
    public function ultimos()
    {
        $items = $this
            ->where('creado_at IS NOT NULL')
            ->order('creado_at DESC')
            ->limit(5)
            ->all();
        foreach ($items as $item)
        {
            $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
            $a[] = $item;
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
        $b['id'] = $a['id'];
        $b['estado'] = '[BORRADO]';
        $this->update($b);
        $a['creado_at'] = date();
        return (new Hechizos)->create($a);
    }

    #
    public function eliminar($a)
    {
        $b['id'] = $a['id'];
        $b['estado'] = '[BORRADO]';
        $b['modificado_in'] = date();
        $this->update($b);
    }
}
