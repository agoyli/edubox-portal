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
        $menu
            ->addChild('Maglumatlar', ['route' => 'edubox_resource_list'])
            ->setAttribute('icon', '<i class="fa fa-bookmark"></i>');
        $menu
            ->addChild('Awtorlar', ['route' => 'edubox_author_list'])
            ->setAttribute('icon', '<i class="fa fa-users"></i>');
        $menu
            ->addChild('Meseleler', ['route' => 'edubox_problem_list'])
            ->setAttribute('icon', '<i class="fa fa-cube"></i>');

        return $menu;
    }

}