<?php

/**
 * InstallShell.php
 *
 * Configure database
 *
 * $Id: InstallShell.php 2013/11/03 thucnd$
 * 
 */
App::uses('Shell', 'Console');
App::uses('ComponentCollection', 'Controller');

class InstallShell extends AppShell {

    public $path = null;
    public $databaseClassName = 'DATABASE_CONFIG';
    
    protected $_defaultConfig = array(
        'name' => 'default',
        'datasource' => 'Database/Mysql',
        'persistent' => 'false',
        'host' => 'localhost',
        'login' => 'root',
        'password' => 'password',
        'database' => 'project_name',
        'schema' => null,
        'prefix' => null,
        'encoding' => null,
        'port' => null
    );

    function startup() {
        $this->path = APP . 'Config' . DS;
    }

    public function main() {
        // Make new configure database
        $this->bake();
    }

    public function bake() {
        if (!is_dir($this->path)) {
            $this->err(__d('cake_console', '%s not found', $this->path));
            return false;
        }
        
        if(count($this->args) < 4) {
            $this->err(__d('cake_console','params invalid, please input host, user name, password and database'));
            return false;
        }

        $filename = $this->path . 'database.php';
        $oldConfigs = array();

        if (file_exists($filename)) {
            config('database');
            $db = new $this->databaseClassName;
            $temp = get_class_vars(get_class($db));

            foreach ($temp as $configName => $info) {
                $info = array_merge($this->_defaultConfig, $info);

                if (!isset($info['schema'])) {
                    $info['schema'] = null;
                }
                if (!isset($info['encoding'])) {
                    $info['encoding'] = null;
                }
                if (!isset($info['port'])) {
                    $info['port'] = null;
                }

                if ($info['persistent'] === false) {
                    $info['persistent'] = 'false';
                } else {
                    $info['persistent'] = ($info['persistent'] == true) ? 'true' : 'false';
                }
                
                if($configName === 'default') {
                    $info['host'] = $this->args[0];
                    $info['login'] = $this->args[1];
                    $info['password'] = $this->args[2];
                    $info['database'] = $this->args[3];
                }

                $oldConfigs[] = array(
                    'name' => $configName,
                    'datasource' => $info['datasource'],
                    'persistent' => $info['persistent'],
                    'host' => $info['host'],
                    'port' => $info['port'],
                    'login' => $info['login'],
                    'password' => $info['password'],
                    'database' => $info['database'],
                    'prefix' => $info['prefix'],
                    'schema' => $info['schema'],
                    'encoding' => $info['encoding']
                );
            }
        }

        $out = "<?php\n";
        $out .= "class DATABASE_CONFIG {\n\n";

        foreach ($oldConfigs as $config) {
            $config = array_merge($this->_defaultConfig, $config);
            extract($config);

            if (strpos($datasource, 'Database/') === false) {
                $datasource = "Database/{$datasource}";
            }
            $out .= "\tpublic \${$name} = array(\n";
            $out .= "\t\t'datasource' => '{$datasource}',\n";
            $out .= "\t\t'persistent' => {$persistent},\n";
            $out .= "\t\t'host' => '{$host}',\n";

            if ($port) {
                $out .= "\t\t'port' => {$port},\n";
            }

            $out .= "\t\t'login' => '{$login}',\n";
            $out .= "\t\t'password' => '{$password}',\n";
            $out .= "\t\t'database' => '{$database}',\n";

            if ($schema) {
                $out .= "\t\t'schema' => '{$schema}',\n";
            }

            if ($prefix) {
                $out .= "\t\t'prefix' => '{$prefix}',\n";
            }

            if ($encoding) {
                $out .= "\t\t'encoding' => '{$encoding}'\n";
            }

            $out .= "\t);\n";
        }

        $out .= "}\n";

        $filename = $this->path . 'database.php';

        return $this->createFile($filename, $out);
    }

    public function createFile($path, $contents) {
        $path = str_replace(DS . DS, DS, $path);

        $this->out();
        $this->out(__d('cake_console', 'Creating file %s', $path));
    
        $File = new File($path, true);
        if ($File->exists() && $File->writable()) {
            $data = $File->prepare($contents);
            $File->write($data);
            $this->out(__d('cake_console', '<success>Wrote</success> `%s`', $path));
            return true;
        } else {
            $this->err(__d('cake_console', '<error>Could not write to `%s`</error>.', $path), 2);
            return false;
        }
    }

}
