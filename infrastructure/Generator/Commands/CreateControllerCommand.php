<?php

namespace Infrastructure\Generator\Commands;

class CreateControllerCommand extends \Illuminate\Routing\Console\ControllerMakeCommand
{
    use WithAppOption;

    protected function getStub(): string
    {
        if ($this->hasDomain()) {
            return __DIR__.'/../stubs/endpoint.stub';
        }

        return parent::getStub();
    }

    public function getAppendNamespace(): string
    {
        return 'Endpoints';
    }

    protected function buildFormRequestReplacements(array $replace, $modelClass)
    {
        [$namespace, $storeRequestClass, $updateRequestClass] = [
            'Illuminate\\Http', 'Request', 'Request',
        ];

        $domainNamespace = "Domains\\{$this->option('domain')}";

        if ($this->option('requests')) {
            $namespace = "{$domainNamespace}\\Requests";

            [$storeRequestClass, $updateRequestClass] = $this->generateFormRequests(
                $modelClass,
                $storeRequestClass,
                $updateRequestClass
            );
        }

        $namespacedRequests = $namespace.'\\'.$storeRequestClass.';';
        if ($storeRequestClass !== $updateRequestClass) {
            $namespacedRequests .= PHP_EOL.'use '.$namespace.'\\'.$updateRequestClass.';';
        }

        return array_merge($replace, [
            '{{ storeRequest }}' => $storeRequestClass,
            '{{storeRequest}}' => $storeRequestClass,
            '{{ updateRequest }}' => $updateRequestClass,
            '{{updateRequest}}' => $updateRequestClass,
            '{{ namespacedStoreRequest }}' => $namespace.'\\'.$storeRequestClass,
            '{{namespacedStoreRequest}}' => $namespace.'\\'.$storeRequestClass,
            '{{ namespacedUpdateRequest }}' => $namespace.'\\'.$updateRequestClass,
            '{{namespacedUpdateRequest}}' => $namespace.'\\'.$updateRequestClass,
            '{{ namespacedRequests }}' => $namespacedRequests,
            '{{namespacedRequests}}' => $namespacedRequests,
        ]);
    }

    /**
     * Generate the form requests for the given model and classes.
     *
     * @param  string  $modelClass
     * @param  string  $storeRequestClass
     * @param  string  $updateRequestClass
     * @return array
     */
    protected function generateFormRequests($modelClass, $storeRequestClass, $updateRequestClass)
    {
        $storeRequestClass = 'Store'.class_basename($modelClass).'Request';

        $this->call('make:request', [
            'name' => $storeRequestClass,
            '--domain' => $this->option('domain'),
        ]);

        $updateRequestClass = 'Update'.class_basename($modelClass).'Request';

        $this->call('make:request', [
            'name' => $updateRequestClass,
            '--domain' => $this->option('domain'),
        ]);

        return [$storeRequestClass, $updateRequestClass];
    }
}
