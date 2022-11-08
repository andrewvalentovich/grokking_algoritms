<?php

// Задача: имеем свя́зный список, который реализуется через класс Node


class Node
{
    public $data, $next;

    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

// Требуется написать алгоритм, который будет "разворачивать" связи
// в связном списке и вернёт первый элемент этого списка


$ari = new Node('Ari');
$pete = new Node('Pete', $ari);
$steave = new Node('Steave', $pete);
$bob = new Node('Bob', $steave);

print_r($bob);

function turnNode($elNode)
{
    if (is_object($elNode->next)) {
        turnNode($elNode->next);
        $elNode->next->next = $elNode;
        $elNode->next = null;
    }
}


turnNode($bob);

print_r($ari);