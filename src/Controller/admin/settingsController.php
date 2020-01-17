<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 07:26
 */

namespace App\Controller\admin;

use App\Entity\Servers;
use App\Entity\Services;
use App\Entity\Settings;
use App\Form\admin\SettingsType;
use App\Service\publicFunctions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controller for settings.
 *
 * Class settingsController
 * @package App\Controller
 */
class settingsController extends AbstractController
{
    private $publicFunctions;

    public function __construct(publicFunctions $publicFunctions)
    {
        $this->publicFunctions = $publicFunctions;
    }

    /**
     * Function to get/change settings
     *
     * @Route("/admin/settings", name="admin_settings")
     * @return \Symfony\Component\HttpFoundation\Response
     * @var Request $request
     * @throws \Exception
     */
    public function changeSettings(Request $request)
    {
        // deny access for non-admin users
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // === Get repo for query ===
        $servicesRepo = $this->getDoctrine()->getRepository(Services::class);
        $serversRepo = $this->getDoctrine()->getRepository(Servers::class);
        $settingsRepo = $this->getDoctrine()->getRepository(Settings::class);

        // Get settings
        $settings = $settingsRepo->findAll();
        $settingsArr = array();

        foreach($settings as $item) {
            $settingsArr[$item->getName()] = $item->getValue();
        }

        // create and handle form
        $form = $this->createForm(SettingsType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get some data
            $formData = $form->getData();

            // loop form data
            foreach($formData as $key => $value) {
                // get entity manager and update settings
                $entityManager = $this->getDoctrine()->getManager();
                $setting_update = $settingsRepo->findByName($key);
                $setting_update->setValue($value);
                $entityManager->flush();
            }

            return $this->redirectToRoute('admin_settings');
        }

        return $this->render('admin/settings.html.twig', [
                'mainTitle' => $settingsRepo->findOneBy(['name' => 'shop_title'])->getValue(),
                'title' => 'Ustawienia',
                'breadcrumbs' => [
                    ['Panel Administracyjny', $this->generateUrl('admin')],
                    ['Sklep', '#'],
                    ['Zarządzanie', '#'],
                    ['Ustawienia', $this->generateUrl('admin_settings')]
                ],
                'services' => $servicesRepo->findAll(),
                'servers' => $serversRepo->findAll(),
                'form' => $form->createView(),
                'settings' => $settingsArr
            ]
        );
    }
}