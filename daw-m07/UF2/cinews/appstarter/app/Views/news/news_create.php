 <?= $this->extend('layouts/news') ?>

 <?= $this->section('news_content') ?>

 <h2><?= esc($title) ?></h2>
 <?= session()->getFlashdata('error'); ?>
 <?= service('validation')->listErrors(); ?>

 <form action="/news/create" method="POST">
     <?= csrf_field(); ?>

     <label for="title">Title</label>
     <input type="text" name="title" id="title" value="<?= old('title') ?>"></br>

     <label for="body">Text</label>
     <textarea name="body" id="body" cols="45" rows="4"><?= old('body') ?></textarea></br>

     <input type="submit" value="Create news">
 </form>

 <p><a href="/news">Tornar a noticies</a></p>


 <?= $this->endSection() ?>