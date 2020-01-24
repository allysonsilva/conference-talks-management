<?php

namespace App\API\Conference\Services;

use Ds\Set;
use Throwable;
use Carbon\Carbon;
use App\API\Conference\Entity\Talk;
use App\API\Conference\Entity\Track;
use App\API\Conference\Entity\Session;
use App\API\Conference\Entity\Socialize;
use App\API\Conference\Entity\Conference;
use App\API\Conference\ValueObjects\TalksCompare;
use App\API\Conference\Constants\ConferenceConfig;
use App\API\Conference\Contracts\SocializeInterface;

final class ConferenceManager
{
    /**
     * @var \Ds\Set<\App\API\Conference\Entity\Talk>
     */
    private Set $talks;

    private Conference $conference;

    public function __construct(array $talks)
    {
        $this->talks = new Set();

        foreach ($talks as $talkTitle) {
            $this->talks->add(app(Talk::class, ['title' => $talkTitle]));
        }
    }

    public function execute(): array
    {
        try {
            return $this->handleTalks()->organizeStructureToOutput();
        // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            throw $exception;
        }
        // @codeCoverageIgnoreEnd
    }

    public function handleTalks(?Set $talks = null): self
    {
        if (is_null($talks)) {
            $talks = $this->talks;
        }

        $conference = new Conference();

        $talks->sort(new TalksCompare());

        $trackId = 0;

        while (! $talks->isEmpty()) {
            $morningSession = new Session(ConferenceConfig::MORNING_SESSION_DURATION_MINUTES, ConferenceConfig::TRACK_START_TIME);
            $this->fillSession($morningSession, $talks);

            $lunchSession = new Socialize('Lunch', ConferenceConfig::LUNCH_START_TIME);

            $afternoonSession = new Session(ConferenceConfig::AFTERNOON_SESSION_DURATION_MINUTES, ConferenceConfig::POST_LUNCH_SESSION_START_TIME);
            $this->fillSession($afternoonSession, $talks);

            $networkingSession = new Socialize('Networking Event', ConferenceConfig::NETWORKING_START_TIME);

            $track = new Track(++$trackId);
            $track->addSession($morningSession);
            $track->addSocializingEvents($lunchSession);
            $track->addSession($afternoonSession);
            $track->addSocializingEvents($networkingSession);

            $conference->addTrack($track);
        }

        $this->conference = $conference;

        return $this;
    }

    /**
     * Responsável por manipular a talk para determinada sessão.
     * Realizar o math da quantidade de tempo restante da sessão
     * para com a quantidade de tempo da talk.
     *
     * @param \App\API\Conference\Entity\Session $session
     * @param \Ds\Set<\App\API\Conference\Entity\Talk> $talks
     *
     * @return void
     */
    private function fillSession(Session $session, Set $talks): void
    {
        /** @var \Carbon\Carbon */
        $sessionStartTime = clone $session->startTime();

        foreach ($talks->toArray() as $talk) {
            if ($session->hasRoomFor($talk)) {
                // Atualizando a data da talk e adicionando a mesma na sessão
                $talk->startTime(clone $sessionStartTime);
                $session->addTalk(clone $talk);

                // Atualizando - adicionando duração da talk para ser atualizado na talk do próximo math
                $sessionStartTime->addMinutes($talk->durationInMinutes());

                // Removendo a talk que já foi adicionada na sessão do loop do while
                $talks->remove($talk);
            }
        }
    }

    private function organizeStructureToOutput(): array
    {
        $dataToOutput = [];

        foreach ($this->conference->tracks() as $track) {
            $newTrack = [
                'title' => '',
                'talks' => [],
            ];

            $track->populateData($newTrack);

            $dataToOutput[] = $newTrack;
        }

        return $dataToOutput;
    }
}
