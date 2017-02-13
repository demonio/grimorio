<?php
/**
 */
class Hechizos extends ActRecord
{
    #
    public function unoPorId($id)
    {
        $item = (new Hechizos)
            ->where('estado<>? AND id=?', ['[BORRADO]', $id])
            ->first();
        $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
        return $item;
    }

    #
    public function unoPorSlug($slug)
    {
        $slugforbd = _::slug($slug, '%');
        $item = (new Hechizos)
            ->where('estado<>? AND CONCAT(grimorio, capitulo, nombre) LIKE ?', ['[BORRADO]', "%$slugforbd%"])
            ->first();
        if ($item) $item->slug = _::slug("$item->grimorio $item->capitulo $item->nombre");
        return $item;
    }

    #
    public function todos()
    {
        $items = (new Hechizos)
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
        $items = (new Hechizos)
            ->where('estado<>?', '[BORRADO]')
            ->order('creado_at DESC')
            ->limit(10)
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
        $a['ip'] = Input::ip();
        return (new Hechizos)->create($a);
    }

    #
    public function editar($a)
    {
        $b['ip'] = $a['ip'] = Input::ip();
        $item = (new Hechizos)->first($a['id']);
        if ($item->ip <> $a['ip']) return $_SESSION['toast'][] = "No puedes editar un hechizo que no es tuyo.";

        $b['id'] = $a['id'];
        $b['estado'] = '[BORRADO]';
        (new Hechizos)->update($b);

        $a['estado'] = '[PUBLICADO]';
        $a['creado_at'] = date('Y-m-d H:i:s');
        return (new Hechizos)->create($a)
            ? "Hechizo se ha actualizado."
            : "Error actualizando hechizo.";
    }

    #
    public function eliminar($a)
    {
        $b['ip'] = Input::ip();
        $item = (new Hechizos)->first($a['id']);
        if ($item->ip <> $b['ip']) return $_SESSION['toast'][] = "No puedes eliminar un hechizo que no es tuyo.";
        $b['id'] = $a['id'];
        $b['estado'] = '[BORRADO]';
        $b['modificado_in'] = date('Y-m-d H:i:s');
        $_SESSION['toast'][] = ( (new Hechizos)->update($b) )
            ? "Hechizo borrado."
            : "Error borrando hechizo.";
    }
}
