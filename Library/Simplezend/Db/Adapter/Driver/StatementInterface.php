<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Library\Db\Adapter\Driver;

use Library\Db\Adapter\StatementContainerInterface;

interface StatementInterface extends StatementContainerInterface
{

    /**
     * Get resource
     *
     * @return resource
     */
    public function getResource();

    /**
     * Prepare sql
     *
     * @param string $sql
     */
    public function prepare($sql = null);

    /**
     * Check if is prepared
     *
     * @return bool
     */
    public function isPrepared();

    /**
     * Execute
     *
     * @param null $parameters
     * @return ResultInterface
     */
    public function execute($parameters = null);

}
