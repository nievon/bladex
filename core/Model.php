<?php

namespace Core;

use RedBeanPHP\R;

abstract class Model
{
    protected static string $table;

    public static function all()
    {
        return R::findAll(static::$table);
    }

    public static function find($id)
    {
        return R::load(static::$table, $id);
    }

    public static function where($column, $value)
    {
        return R::find(static::$table, "{$column} = ?", [$value]);
    }

    public static function create(array $data)
    {
        $bean = R::dispense(static::$table);
        foreach ($data as $key => $value) {
            $bean->$key = $value;
        }
        return R::store($bean);
    }

    public static function update($id, array $data)
    {
        $bean = R::load(static::$table, $id);
        foreach ($data as $key => $value) {
            $bean->$key = $value;
        }
        return R::store($bean);
    }

    public static function delete($id)
    {
        $bean = R::load(static::$table, $id);
        return R::trash($bean);
    }
}
