<?php

namespace App\Service;

use App\Entity\Coaster;
use Symfony\AI\Agent\AgentInterface;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\AI\Platform\Result\TextResult;

class DescriptionGeneratorService
{
    public function __construct(
        private AgentInterface $agent,
    ) {}

    public function generateForCoaster(Coaster $coaster): void
    {
        // Syntaxe <<< pour écrire de longues chaines
        $prompt = <<<PROMPT
            Tu es une IA qui génére une description sans titre pour des coasters.
            La description doit contenir un paragraphe d'introduction en indiquant l'année de création.
            Une deuxième partie décrit l'histoire du coaster en précisant le constructeur.
            Un troisième et dernière partie affiche une liste des caractèristiques téchnique.
            N'inclus aucune autre information supplementaire que le code HTML brut (sans le ```html).
        PROMPT;

        $messages = new MessageBag(
            Message::forSystem($prompt),
            Message::ofUser($coaster->getName(). ' '. $coaster->getPark()?->getName())
        );

        $result = $this->agent->call($messages)->getResult();

        if ($result instanceof TextResult) {
            $coaster->setDescription($result->getcontent());
        }
    }
}