<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Entity\Medication;
use App\Service\FileUploader;

#[AsController]
class MedicationController extends AbstractController
{
    public function __invoke(Request $request, FileUploader $fileUploader): Medication
    {
        $uploadedFile = $request->files->get('image');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }
 
        $entity = new Medication();
        $entity->setName($request->get('name'));
        $entity->setWeight($request->get('weight'));
        $entity->setCode($request->get('code'));
 
        $entity->setImage($fileUploader->upload($uploadedFile));
 
        return $entity;
    }
}
