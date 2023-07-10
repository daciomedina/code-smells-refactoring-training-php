<?php

declare(strict_types=1);

namespace App;

class Rover
{
    const DISPLACEMENT = 1;
    private Direction $direction;
    private Coordinates $coordinates;

    public function __construct(int $x, int $y, string $direction)
    {
        $this->direction = Direction::create($direction);
        $this->coordinates = new Coordinates($y, $x);
    }

    public function receive(string $commandsSequence): void
    {
        $commands = $this->extractCommandsFrom($commandsSequence);
        $this->processCommands($commands);

    }

    private function processCommand($command): void
    {
        if ($command === "l") {
            $this->direction = $this->direction->rotateLeft();
        } else if ($command === "r") {
            $this->direction = $this->direction->rotateRight();
        } else if ($command === "f") {
            $this->coordinates = $this->direction->move(self::DISPLACEMENT, $this->coordinates);
        } else {
            $this->coordinates = $this->direction->move(-self::DISPLACEMENT, $this->coordinates);
        }
    }

    private function extractCommandsFrom(string $commandsSequence): array
    {
        $commandsSequenceLenght = strlen($commandsSequence);
        $commands = [];
        for ($i = 0; $i < $commandsSequenceLenght; ++$i) {
            $commands[] = substr($commandsSequence, $i, 1);
        }
        return $commands;
    }

    private function processCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->processCommand($command);
        }
    }
}