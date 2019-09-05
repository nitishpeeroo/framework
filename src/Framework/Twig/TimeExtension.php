<?php
    namespace Framework\Twig;

    use Twig\Extension\AbstractExtension;
    use Twig\TwigFilter;

class TimeExtension extends AbstractExtension
{

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('timeago', [$this, 'timeago'], ['is_safe' => ['html']])
        ];
    }

    public function timeago(\DateTime $date, string $format = 'd/m/Y H:i')
    {
        return '<span class="timeago" datetime="' . $date->format(\DateTime::ISO8601) . '">' . $date->format($format) . '</span>';
    }
}
