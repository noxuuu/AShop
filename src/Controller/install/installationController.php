<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 15:32
 */

namespace App\Controller\install;

use App\Form\install\DatabaseType;
use App\Service\install\dynamicDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Controller for installation process.
 *
 * Class dashboardController
 * @package App\Controller
 */
class installationController extends AbstractController
{
    private $dynamicDatabase;

    public function __construct(dynamicDatabase $dynamicDatabase)
    {
        $this->dynamicDatabase = $dynamicDatabase;
    }

    /**
     * Get admin dashboard
     *
     * @Route("/install/{step}", name="install")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function install(Request $request, int $step = 1)
    {
        $session = $request->getSession();

        switch ($step)
        {
            case 1: {
                $dbform = $this->createForm(DatabaseType::class);
                $dbform->handleRequest($request);

                $connectionStatus = array('status' => 'NULL');

                if ($dbform->isSubmitted() && $dbform->isValid()) {
                    $data = $dbform->getData();

                    $connectionStatus = $this->dynamicDatabase->getConnectionStatus($data['host'], $data['user'], $data['password'], $data['dbname']);

                    if($connectionStatus['status'] == "OK")
                    {
                        $session->set('db_info', $data);
                        return $this->redirectToRoute('install', array('step' => 2));
                    }
                }

                return $this->render('install/install.html.twig', [
                    'step' => $step,
                    'db_form' => $dbform->createView(),
                    'db_error' => $connectionStatus
                ]);
            }
            case 2: {
                $db_info = $session->get('db_info');

                if(empty($db_info)) {
                    return $this->redirectToRoute('install', array('step' => 1));
                }

                // check license info
                $licenseResponse = "VALID";

                if($licenseResponse != "VALID")
                {

                }

                // save db info and create tables


                // insert default data


                // render error from form


                // clear session info
                $session->invalidate();

                return $this->render('install/install.html.twig', [
                    'step' => $step
                ]);
            }
            case 3: {

                return $this->render('install/install.html.twig', [
                    'step' => $step
                ]);
            }
            case 4: {
                // clear session info
                $session->invalidate();


                break;
            }
        }
    }
}