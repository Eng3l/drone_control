<?php
 
namespace App\Service;

use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\UrlHelper;
 
class FileUploader
{
    const ALLOWED_EXT = ['png', 'jpg', 'gif'];

    private $uploadPath;
    private $slugger;
    private $urlHelper;
    private $relativeUploadsDir;
 
    public function __construct($publicPath, $uploadPath, SluggerInterface $slugger, UrlHelper $urlHelper)
    {
        $this->uploadPath = $uploadPath;
        $this->slugger = $slugger;
        $this->urlHelper = $urlHelper;
 
        $this->relativeUploadsDir = str_replace($publicPath, '', $this->uploadPath) . '/';
    }
 
    public function upload(UploadedFile $file)
    {
        $ext = $file->guessExtension();
        if (!in_array($ext, self::ALLOWED_EXT)) {
            throw new BadRequestException('File type not allowed');
        }

        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $ext;
 
        $file->move($this->getuploadPath(), $fileName);
 
        return $fileName;
    }
 
    public function getuploadPath()
    {
        return $this->uploadPath;
    }
 
    public function getUrl(?string $fileName, bool $absolute = true)
    {
        if (empty($fileName)) return null;
 
        if ($absolute) {
            return $this->urlHelper->getAbsoluteUrl($this->relativeUploadsDir.$fileName);
        }
 
        return $this->urlHelper->getRelativePath($this->relativeUploadsDir.$fileName);
    }
}