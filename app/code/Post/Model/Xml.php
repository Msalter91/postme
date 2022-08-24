<?php

declare(strict_types=1);

class Xml
{
    public function downloadTemplate(): void
    {
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="../app/XML/template.xml"');
        readfile('../app/XML/template.xml');
    }

    public function createXmlFromPost($id): void
    {
        $getRepositoryPost = new PostRepository();
        $post = $getRepositoryPost->getById(intval($id));

        $sxe = new SimpleXMLElement('<?xml version=\'1.0\' standalone=\'yes\'?><post></post>');
        $sxe->addChild('Posttitle', $post->getTitle());
        $sxe->addChild('id', strval($post->getId()));
        $sxe->addChild('body', $post->getBody());
        $sxe->addChild('createdAt', $post->getCreatedAt());
        $user = $sxe->addChild('user');

        $repositoryUser = new UserRepository();
        $userId = $post->getUserId();
        $userInformation = $repositoryUser->getById($userId);

        $user->addChild('username', $userInformation->getName());
        $user->addChild('useremail', $userInformation->getEmail());
        $sxe->saveXML('../app/XML/' . $post->getTitle() . '.xml');

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename=" ' . $post->getTitle() . '.xml"');
        readfile('../app/XML/' . $post->getTitle() . '.xml');
    }

    public function checkValidFile(): array|null
    {
        $errors = [
            'no_file' => '',
            'file_size' => '',
            'file_type' => '',
            'post_title' => '',
            'post_body' => '',
        ];

        if (empty($_FILES)) {
            $errors['no_file'] = 'No file uploaded';
            return $errors;
        }
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors['no_file'] = 'No file uploaded';
                return $errors;
            case UPLOAD_ERR_INI_SIZE:
                $errors['file_size'] = 'File is too large';
                return $errors;
            default:
                $errors['no_file'] = 'An error occoured with the upload';
                return $errors;
        }

        if ($_FILES['file']['size'] > 1000000) {
            $errors['file_size'] = 'File is too large';
            return $errors;
        }

        $mime_types = ['application/xml', 'text/xml'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $_FILES['file']['tmp_name']);

        if (!in_array($mime_type, $mime_types)) {
            $errors['file_type'] = 'File must be a valid xml file';
            return $errors;
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function moveFile(): SimpleXMLElement
    {
        $pathinfo = pathinfo($_FILES['file']['name']);

        $base = $pathinfo['filename'];

        $base = preg_replace('/^[a-zA-Z0-9-_]/', '_', $base);

        $base = mb_substr($base, 0, 255);

        $date = date('d-m-y h:i:s');

        $fileName = $base . $date . '.' . $pathinfo['extension'];

        $destination = "/uploads/{$fileName}";

        if (
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                '/Applications/XAMPP/xamppfiles/htdocs/postme/app/code/Post/Controllers' . $destination
            )
        ) {
            return simplexml_load_file(
                '/Applications/XAMPP/xamppfiles/htdocs/postme/app/code/Post/Controllers' . $destination
            );
        }
            throw new Exception('Unable to move file');
    }
}
