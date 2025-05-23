<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property int $post_id
 * @property string $user_name
 * @property string|null $email
 * @property string $content
 * @property string $status
 * @property \Cake\I18n\DateTime|null $created
 *
 * @property \App\Model\Entity\Post $post
 */
class Comment extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'post_id' => true,
        'user_name' => true,
        'email' => true,
        'content' => true,
        'status' => true,
        'created' => true,
        'post' => true,
    ];
}
