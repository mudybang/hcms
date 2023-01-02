<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *```
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'	       => APPPATH
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        'Company\Company' => ROOTPATH. 'Company/Company',
        'Auth\User' => ROOTPATH. 'Auth/User',
        'Auth\Group' => ROOTPATH. 'Auth/Group',
        'Auth\Perm' => ROOTPATH. 'Auth/Perm',
        'Master\Branch' => ROOTPATH. 'Master/Branch',
        'Master\Department' => ROOTPATH. 'Master/Department',
        'Master\Jobtitle' => ROOTPATH. 'Master/Jobtitle',
        'Master\Employmentstatus' => ROOTPATH. 'Master/Employmentstatus',
        'Master\Education' => ROOTPATH. 'Master/Education',
        'Master\Sdp' => ROOTPATH. 'Master/Sdp',
        'Master\Project' => ROOTPATH. 'Master/Project',
        'Modules\Employee' => ROOTPATH. 'Modules/Employee',
        'Modules\Contract' => ROOTPATH. 'Modules/Contract',
        'Modules\SdpReport' => ROOTPATH. 'Modules/SdpReport',
        'Modules\History' => ROOTPATH. 'Modules/History',
        'Modules\Reward' => ROOTPATH. 'Modules/Reward',
        'Modules\Warning' => ROOTPATH. 'Modules/Warning',
        'Modules\Insurance' => ROOTPATH. 'Modules/Insurance',
        'Modules\Loan' => ROOTPATH. 'Modules/Loan',
        'Modules\Bpjs' => ROOTPATH. 'Modules/Bpjs',
        'Payroll\Employee' => ROOTPATH. 'Payroll/Employee',
        'Payroll\Grade' => ROOTPATH. 'Payroll/Grade',
        'Payroll\Component' => ROOTPATH. 'Payroll/Component',
        'Payroll\Perm' => ROOTPATH. 'Payroll/Perm'
    ];

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *```
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *```
     *
     * @var array<string, string>
     */
    public $classmap = [];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     * ```
     *	  $files = [
     *	 	   '/path/to/my/file.php',
     *    ];
     * ```
     *
     * @var array<int, string>
     */
    public $files = [];
}
