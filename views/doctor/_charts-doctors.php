<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

if(!empty($doctors) and is_array($doctors)):
?>
    <div class="charts-doctors">
        <h4>Charts doctors</h4>
        <ul>
        <?php foreach ($doctors as $doctor): ?>
            <li>
                <?= Html::a($doctor->doctor->user->fullname, ['site/doctor', 'id' => $doctor->doctor->id], ['class' => 'profile-link']) ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>

<?php endif; ?>