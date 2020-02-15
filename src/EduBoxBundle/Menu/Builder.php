<?php


namespace EduBoxBundle\Menu;


use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu
            ->addChild('Kitaphana', ['route' => 'edubox_book_list'])
            ->setAttribute('icon', '<i class="fa fa-book"></i>');
        $menu['Kitaphana']
            ->addChild('Kitaplar', ['route' => 'edubox_book_list'])
            ->setAttribute('icon', '<i class="fa fa-book"></i>');
        $menu['Kitaphana']
            ->addChild('Awtorlar', ['route' => 'edubox_author_list'])
            ->setAttribute('icon', '<i class="fa fa-users"></i>');
        $menu
            ->addChild('Maglumatlar', ['route' => 'edubox_resource_list'])
            ->setAttribute('icon', '<i class="fa fa-bookmark"></i>');
        $menu
            ->addChild('Meseleler', ['route' => 'edubox_problem_list'])
            ->setAttribute('icon', '<i class="fa fa-cube"></i>');
        $menu
            ->addChild('Habarlaşmak', ['route' => 'edubox_contact'])
            ->setAttribute('icon', '<i class="fa fa-envelope"></i>');

        return $menu;
    }

}