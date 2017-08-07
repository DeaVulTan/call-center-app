<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * SoundUploadedFile
 *
 * @author Tursunov Artem <artem.tur@gmail.com>
 */
class SoundUploadedFile extends CUploadedFile {
    public function convertWavFile() {
        var_dump($this->extensionName); exit;
    }
}

?>
