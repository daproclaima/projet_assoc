<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 21/12/2018
 * Time: 10:07
 */

namespace App\Service\Twig;


use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public conSt NB_SUMMERY_CHAR = 200;
    public conSt NB_SUMMERY_CHAR_EVENT = 100;

    public function getFilters()
    {
        return [
            new \Twig_filter('summary', function ($text) {
                # Supprimer les balises HTML
                $string = strip_tags($text);

                # si mon string est superieur à 200, je continue
                if (strlen($string) > self::NB_SUMMERY_CHAR) {
                    # Je coupe ma chaine à 200
                    $stringCut = substr($string, 0, self::NB_SUMMERY_CHAR);

                    # Je ne dois pas couper un mot en plein milieu...
                    $string = substr($stringCut, 0, strripos($stringCut, ' ')) . '...';
                }

                return $string;
            },['is_safe' => ['html']])
            ,
            new \Twig_filter('summaryEvent', function ($text) {
                # Supprimer les balises HTML
                $string = strip_tags($text);

                # si mon string est superieur à 100, je continue
                if (strlen($string) > self::NB_SUMMERY_CHAR_EVENT) {
                    # Je coupe ma chaine à 100
                    $stringCut = substr($string, 0, self::NB_SUMMERY_CHAR_EVENT);

                    # Je ne dois pas couper un mot en plein milieu...
                    $string = substr($stringCut, 0, strripos($stringCut, ' ')) . '...';
                }

                return $string;
            },['is_safe' => ['html']])
        ];
    }
}