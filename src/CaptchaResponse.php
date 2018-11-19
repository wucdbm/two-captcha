<?php

namespace Wucdbm\Component\TwoCaptcha;

class CaptchaResponse {

    /** @var bool */
    protected $solved;

    /** @var string|null */
    protected $answer;

    public function __construct(bool $solved, ?string $answer) {
        $this->solved = $solved;
        $this->answer = $answer;
    }

    public function isSolved(): bool {
        return $this->solved;
    }

    public function getAnswer(): ?string {
        return $this->answer;
    }

}