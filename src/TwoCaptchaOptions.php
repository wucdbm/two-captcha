<?php

namespace Wucdbm\Component\TwoCaptcha;

class TwoCaptchaOptions {

    protected $options = [
//        0 - captcha contains one word
//        1 - captcha contains two or more words
        'phrase' => 0,
//        0 - captcha in not case sensitive
//        1 - captcha is case sensitive
        'regsense' => 0,
//        0 - not specified
//        1 - captcha contains only numbers
//        2 - captcha contains only letters
//        3 - captcha contains only numbers OR only letters
//        4 - captcha contains both numbers AND letters
        'numeric' => 0,
//        0 - not specified
//        1 - captcha requires calculation (e.g. type the result 4 + 8 = )
        'calc' => 0,
//        0 - not specified
//        1..20 - minimal number of symbols in captcha
        'min_len' => 0,
//        0 - not specified
//        1..20 - maximal number of symbols in captcha
        'max_len' => 0,
//        0 - not specified
//        1 - Cyrillic captcha
//        2 - Latin captcha
        'language' => 0,
//        0 - disabled
//        1 - enabled.
//        If enabled in.php will include Access-Control-Allow-Origin:* header in the response.
//        Used for cross-domain AJAX requests in web applications.
        'header_acao' => 0
    ];

    public function get(array $options) {
        return array_merge($this->options, $options);
    }

    public function isOneWord(): self {
        $this->options['phrase'] = 0;

        return $this;
    }

    public function isMoreThanOneWord(): self {
        $this->options['phrase'] = 1;

        return $this;
    }

    public function isCaseInsensitive(): self {
        $this->options['numeric'] = 0;

        return $this;
    }

    public function isCaseSensitive(): self {
        $this->options['numeric'] = 1;

        return $this;
    }

    public function containsAnyCharacter(): self {
        $this->options['numeric'] = 0;

        return $this;
    }

    public function containsNumbersOnly(): self {
        $this->options['numeric'] = 1;

        return $this;
    }

    public function containsLettersOnly(): self {
        $this->options['numeric'] = 2;

        return $this;
    }

    public function containsOnlyNumbersOrOnlyLetters(): self {
        $this->options['numeric'] = 3;

        return $this;
    }

    public function containsNumbersAndLetters(): self {
        $this->options['numeric'] = 4;

        return $this;
    }

    public function noCalculationRequired(): self {
        $this->options['calc'] = 0;

        return $this;
    }

    public function requiresCalculation(): self {
        $this->options['calc'] = 1;

        return $this;
    }

    public function length(?int $min, ?int $max): self {
        $this->options['min_len'] = $min && $min <= 20 ? $min : 0;
        $this->options['max_len'] = $max && $max <= 20 ? $max : 0;

        return $this;
    }

    public function useLatinOrCyrillic(): self {
        $this->options['language'] = 0;

        return $this;
    }

    public function useCyrillic(): self {
        $this->options['language'] = 1;

        return $this;
    }

    public function useLatin(): self {
        $this->options['language'] = 2;

        return $this;
    }

    public function enableACAO(): self {
        $this->options['header_acao'] = 1;

        return $this;
    }

    public function disableACAO(): self {
        $this->options['header_acao'] = 0;

        return $this;
    }

    /**
     * https://2captcha.com/2captcha-api#language
     *
     * @param string|null $lang
     *
     * @return TwoCaptchaOptions
     */
    public function setLang(?string $lang): self {
        if (null === $lang) {
            unset($this->options['lang']);

            return $this;
        }

        $this->options['lang'] = $lang;

        return $this;
    }

    /**
     * Text will be shown to worker to help him to solve the captcha correctly.
     * For example: type red symbols only.
     *
     * @param null|string $instructions
     *
     * @return $this
     */
    public function setTextInstructions(?string $instructions): self {
        if (null === $instructions) {
            unset($this->options['textinstructions']);

            return $this;
        }

        if (mb_strlen($instructions, 'utf8') > 140) {
            $instructions = substr($instructions, 0, 140);
        }

        $this->options['textinstructions'] = $instructions;

        return $this;
    }

    /**
     * Image will be shown to worker to help him to solve the captcha correctly.
     * Server accepts images from multipart form or base64-encoded.
     *
     * @param null|string $instructions
     *
     * @return $this
     */
    public function setImgInstructions(?string $instructions): self {
        if (null === $instructions) {
            unset($this->options['imginstructions']);

            return $this;
        }

        $this->options['imginstructions'] = $instructions;

        return $this;
    }

    /**
     * URL for pingback (callback) response that will be sent when captcha is solved.
     * URL should be registered on the server. More info here.
     * https://2captcha.com/2captcha-api#pingback
     *
     * @param null|string $url
     *
     * @return $this
     */
    public function setPingBackUrl(?string $url): self {
        if (null === $url) {
            unset($this->options['pingback']);

            return $this;
        }

        $this->options['pingback'] = $url;

        return $this;
    }

    /**ID of software developer.
     * Developers who integrated their software with 2captcha get reward: 10% of spendings of their software users.
     *
     * @param null|int $id
     *
     * @return $this
     */
    public function setSoftId(int $id): self {
        if (null === $id) {
            unset($this->options['soft_id']);

            return $this;
        }

        $this->options['soft_id'] = $id;

        return $this;
    }

}