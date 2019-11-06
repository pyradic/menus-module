<?php

namespace Pyro\MenusModule\Seeder;

use Anomaly\Streams\Platform\Model\EloquentModel;

class AdminFooterMenuSeeder extends \Pyro\Platform\Database\Seeder
{
    public function run()
    {
        /** @var MenuModuleSeederHelper $helper */
        $helper = $this->helper(MenuModuleSeederHelper::class);
        $helper->menu('admin_footer', 'Admin Footer', 'De admin footer menu')->truncate();

        $items = [
            'Todo'          => [ 'Notitie Maken', 'Agendaoverzicht', 'Algemene afspraak plannen', 'Alle afspraken' ],
            'Info'          => [ 'Bekijk informatie', 'Plaats informatie', 'Informatie verwijderen', 'Acties van gebruikers bekijken' ],
            'Sociale Kaart' => [ 'Overzicht sociale kaart', 'Organisatie zoeken', 'Organisatie zoeken op trefwoord', 'Organisatieoverzicht', 'Nieuwe organisatie', 'Nieuw Domein toevoegen', ],
            'Vacatures'     => [ 'Nieuwe vacature', 'Overzicht vacatures', 'Vacature zoeken' ],
            'Gebruikers'    => [ 'Loginprofiel wijzigen', 'Mijn todos' ],
            'Beheer'        => [ 'Overzicht modules', 'Gebruikersoverzicht', 'Nieuwe gebruiker', 'Overzicht afdelingen', 'Nieuwe afdeling', 'Authorisaties per module', ],
        ];

        foreach ($items as $title => $childTitles) {
            $parent = $helper->label($title);
            foreach ($childTitles as $childTitle) {
                $helper->url($childTitle, [ 'url' => '#' ], [ 'parent_id' => $parent->getId() ]);
            }
        }
    }
}
