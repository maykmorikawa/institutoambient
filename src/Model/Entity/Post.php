<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $category_id
 * @property int $user_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string $slug
 * @property string|null $excerpt
 * @property string|null $image
 * @property string $status
 * @property \Cake\I18n\DateTime|null $published
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tag[] $tags
 */
class Post extends Entity
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
        'title' => true,
        'content' => true,
        'category_id' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'slug' => true,
        'excerpt' => true,
        'image' => true,
        'status' => true,
        'published' => true,
        'category' => true,
        'user' => true,
        'tags' => true,
    ];
}
