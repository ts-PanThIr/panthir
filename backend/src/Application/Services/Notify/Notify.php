<?php

namespace Panthir\Application\Services\Notify;

class Notify implements NotifyInterface
{
    const ERROR = "danger";
    const WARNING = "warning";
    const INFO = "info";
    const SUCCESS = "success";

    private array $messages = array();

    public function addMessage($type, $text){
        $this->messages[] = array(
            "type" => $type,
            "text" => $text
        );
    }

    /**
     * @param string $data
     * @return string
     */
    public function newReturn($data): string
    {
        if(empty($data)){
            return '{"data": "", "notify": '.json_encode($this->messages).'}';
        }
        if(in_array(substr($data, 0, 1), ['{', '['])) {
            return '{"data":'.$data.', "notify": '.json_encode($this->messages).'}';
        }
        return '{"data":"'.$data.'", "notify": '.json_encode($this->messages).'}';
    }
}