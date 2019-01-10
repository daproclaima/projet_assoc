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
    public function getFilters()
    {
        return [
            new \Twig_filter('summary', function ($text) {
                # Supprimer les balises HTML
                $string = strip_tags($text);

                # si mon string est superieur à 170, je continue
                if (strlen($string) > self::NB_SUMMERY_CHAR) {
                    # Je coupe ma chaine à 170
                    $stringCut = substr($string, 0, self::NB_SUMMERY_CHAR);

                    # Je ne doit pas couper un mot en plain milieur...
                    $string = substr($stringCut, 0, strripos($stringCut, ' ')) . '...';
                }

                return $string;
            },['is_safe' => ['html']])
        ];
    }
}