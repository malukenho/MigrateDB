<?php
namespace MigrateDB\Interfaces;
/**
 * If you want to modify the behave of application, do it by Filters :)
 * The implementation of filter behave like a DECORATOR PATTERN, but it's not
 * a DECORATOR (._. ) Why?
 *
 * The filter provide to you a form to manipule result of columns and values
 * in execution time of query mount. You can substitute values here :D
 * 
 * Example:
 * <code>
 * 	if ('NULL' === $key)
 *  	return "0";
 * </code>
 * 
 * @author  Jefersson Nathan <malukenho@phpse.net>
 * @package MigrationDB
 * @since   1.0
 */
interface FilterParams 
{
    /**
     * @return mixed
     * @author Jefersson Nathan <malukenho@phpse.net>
     */
    public function keekFilterParams($key, $value, $adtional = null);
}