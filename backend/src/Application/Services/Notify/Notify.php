<?php

namespace Panthir\Application\Services\Notify;

class Notify implements NotifyInterface
{
    const ERROR = "error";
    const WARNING = "warning";
    const INFO = "info";
    const SUCCESS = "success";

    private array $messages = array();

    public function addMessage($type, $text)
    {
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
        $return = [
            'data' => $data,
            'notify' => $this->messages
        ];

        return json_encode($return);
    }

    public function getTreeToSerialize($data): array
    {
        return [
            'data' => $data,
            'notify' => $this->messages
        ];
    }
}
