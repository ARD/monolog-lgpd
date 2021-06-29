<?php
declare (strict_types = 1);

namespace ARD\Monolog\FilterSensitive;

class FilterSensitiveProcessor
{
    public $filters = [
        FilterCPF::class,
        FilterCNPJ::class,
        FilterEmail::class,
        FilterIP::class
    ];

    public function __invoke(array $record): array
    {
        return $this->filterSensitiveData($record);
    }

    private function filterSensitiveData(array $record): array {
        $arrToJson = json_encode($record);

        foreach ($this->filters as $filter) {
            $arrToJson = preg_replace($filter::pattern(), $filter::replace(), $arrToJson);
        }

        return json_decode($arrToJson, true);
    }

    public function addCustomFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

    public function removeFilter(string ...$excludedFilters)
    {
        foreach($excludedFilters as $excludedFilter) {            
            foreach($this->filters as $key => $filter) {
                if($excludedFilter === $filter) {
                    unset($this->filters[$key]);
                    break;                    
                }
            }
        }        
    }
}
