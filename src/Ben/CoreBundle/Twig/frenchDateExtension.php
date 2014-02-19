<?php

namespace Ben\CoreBundle\Twig;

/**
 * French Date Twig Filter Extension
 * This class adds the "french_date" filter to Twig across the website.
 *
 * @author Zboubidoo <zboubidoo@nxtelevision.com>
 * @version 1.0
 */
class FrenchDateExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            // Returns a given date using French format
            new \Twig_SimpleFilter('french_date', array($this, 'frenchDateFilter')),
        );
    }

    /**
     * Returns a given date using French format
     * French format looks like "Mardi 21 Janvier 2013", hence "<day of the week> <day> <month> <year>".
     *
     * @param \DateTime $date: the date
     * @return string
     */  
    public function frenchDateFilter($date)
    {
        $monthList = array(
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre',
        );
        
        $day = $date->format('j');
        $month = $date->format('m');
        $year = $date->format('Y');
        $monthName = $monthList[$month - 1];
        
        return $day . ' ' . $monthName . ' ' . $year;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'nx_french_date_filter';
    }
}
