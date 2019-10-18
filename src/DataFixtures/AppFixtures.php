<?php

namespace App\DataFixtures;

use App\Entity\Groups;
use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) // load after installation
    {
        // ------------------ Set default settings ------------------
        $settings = new Settings();
        $settings->setName('shop_address');
        $settings->setValue('http://instalation_proccess.pl');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('shop_commands');
        $settings->setValue('ashop;sklepsms;shopsms;skleppsc;shoppsc;');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('allow_steam_bot_info');
        $settings->setValue('0');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('steam_bot_login');
        $settings->setValue('');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('steam_bot_password');
        $settings->setValue('');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('allow_psc_payment');
        $settings->setValue('1');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('shop_title');
        $settings->setValue('AShop ~ System sklepu dla wymagających!');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('debug');
        $settings->setValue('0');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('payment_url_livetime');
        $settings->setValue('300');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('stats_target_income');
        $settings->setValue('100');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('stats_target_sold_services');
        $settings->setValue('30');
        $manager->persist($settings);

        $settings = new Settings();
        $settings->setName('stats_target_send_sms');
        $settings->setValue('30');
        $manager->persist($settings);


        // ------------------ Set default groups ------------------
        $groups = new Groups();
        $groups->setName('Administrator');
        $groups->setStyle('color:red; text-shadow: 0px 0px 8px #FF0000;');
        $manager->persist($groups);

        $groups = new Groups();
        $groups->setName('Użytkownik');
        $groups->setStyle('color:#; text-shadow: 0px 0px 8px #262323;');
        $manager->persist($groups);


        // Do it!
        $manager->flush();
    }
}
