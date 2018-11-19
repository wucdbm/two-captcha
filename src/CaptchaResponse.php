<?php

/*
 * This file is part of the Wucdbm TwoCaptcha package.
 *
 * Copyright (c) Martin Kirilov <wucdbm@gmail.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
