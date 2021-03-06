<?php

function petitionfixnavs_getmoduleinfo()
{
    return [
        'name' => 'Fixnavs in petitions',
        'version' => '2.0.0',
        'author' => '`2Oliver Brendel, refactoring by `%IDMarinas`0, <a href="//draconia.infommo.es">draconia.infommo.es</a>',
        'category' => 'Administrative',
        'download' => 'http://dragonprime.net/dls/petitionfixnavs.zip',
        'requires' => [
            'lotgd' => '>=4.0.0|Need a version equal or greater than 4.0.0 IDMarinas Edition'
        ]
    ];
}

function petitionfixnavs_install()
{
    module_addhook_priority('footer-viewpetition');

    return true;
}

function petitionfixnavs_uninstall()
{
    return true;
}

function petitionfixnavs_dohook($hookname, $args)
{
    if ('footer-viewpetition' == $hookname && 'view' == \LotgdHttp::getQuery('op'))
    {
        $id = \LotgdHttp::getQuery('id');

        \LotgdNavigation::addHeader('common.category.navigation', [ 'textDomain' => 'navigation-app']);

        \LotgdNavigation::addNav('navigation.nav.fix', "runmodule.php?module=petitionfixnavs&id={$id}", [ 'textDomain' => 'module-petitionfixnavs' ]);
    }

    return $args;
}

function petitionfixnavs_run()
{
    global $session;

    $textDomain = 'module-petitionfixnavs';

    page_header('title', [], $textDomain);

    $id = (int) \LotgdHttp::getQuery('id');

    if ($id)
    {
        $repository = \Doctrine::getRepository('LotgdCore:Characters');
        $query = \Doctrine::createQueryBuilder();

        $accountId = $query->select('u.author')
            ->from('LotgdCore:Petitions', 'u')

            ->where('u.petitionid = :id')

            ->setParameter('id', $id)

            ->getQuery()
            ->getSingleScalarResult()
        ;

        $character = $repository->findBy([ 'acct' => $accountId ]);
        if ($character)
        {
            require_once 'lib/systemmail.php';

            $character->setAllowednavs([])
                ->setSpecialinc('')
            ;

            \Doctrine::persist($character);
            \Doctrine::flush();

            $commentary = \LotgdLocator::get(\Lotgd\Core\Output\Commentary::class);
            $commentary->saveComment([
                'section' => "pet-{$id}",
                'comment' => '/me '.\LotgdTranslator::t('commentary', [], $textDomain)
            ]);

            systemmail($accountId,
                ['mail.subject', [], $textDomain],
                ['mail.message', [ 'moderator' => $session['user']['name'] ], $textDomain ]
            );
        }

        return redirect("viewpetition.php?op=view&id={$id}");
    }

    return redirect('viewpetition.php');

}
