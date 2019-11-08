<?php

class Image {
  private $uploadFolder = CURRENT_DIR;
  private $uploadFieldName;
  private $username;

  public function __construct($fieldName, $username) {
    $this->uploadFieldName = $fieldName;
    $this->username = $username;
  }

  private function getNewFileName() {
    $originalFileName = pathinfo(
      $_FILES["{$this->uploadFieldName}"]['name'],
      PATHINFO_FILENAME);

    $originalFileExtension = pathinfo(
      $_FILES["{$this->uploadFieldName}"]['name'],
      PATHINFO_EXTENSION);

    $fileName = $originalFileName . "-{$this->username}-" . time() . "." . $originalFileExtension;

    return $fileName;
  }

  private function getFileUploadPath() {
    // Creating array of adress segments
    $path_segments = [$this->uploadFolder, 'uploads', $this->getNewFileName()];

    // Returning the final upload path for file
    return join(DIRECTORY_SEPARATOR, $path_segments);
  }

  private function isValidImage($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png', 'pdf'];

    // getting file extension and mime type
    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = mime_content_type($temporary_path);

    // Validating mime type and file extension
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    // Returning the result
    return $file_extension_is_valid && $mime_type_is_valid;
  }

  public function upload() {
    $image_filename = $_FILES["{$this->uploadFieldName}"]['name'];
    $temporary_image_path = $_FILES["{$this->uploadFieldName}"]['tmp_name'];
    $new_image_path = $this->getFileUploadPath($image_filename);

    // Checking if the file is valid image
    if ($this->isValidImage($temporary_image_path, $new_image_path)) {

      // moving the file to uploads folder
      move_uploaded_file($temporary_image_path, $new_image_path);

      // Otherwise setting the success message in session
      return $new_image_path;
    
    } else if ($_FILES["{$this->uploadFieldName}"]['size'] > 10000000) {
      errorHandler(
        422,
        'Invalid Image Size',
        new Exception('Size of the image is more than 10 MB.'));
    } else {
      errorHandler(
        422,
        'Invalid Image Type',
        new Exception('MIME Type of image is invalid.'));
    }
  }

  public function remove($imagePath) {
    unlink($imagePath);
  }
}

?>