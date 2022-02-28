<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Image
 *
 * @property int $id
 * @property int $owner_id
 * @property string $filename
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Owner $owner
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 */
	class Image extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Owner
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $image
 * @property-read int|null $image_count
 * @property-read \App\Models\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|Owner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Owner newQuery()
 * @method static \Illuminate\Database\Query\Builder|Owner onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Owner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Owner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Owner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Owner withoutTrashed()
 */
	class Owner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PrimaryCategory
 *
 * @property int $id
 * @property string $name
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SecondaryCategory[] $secondary
 * @property-read int|null $secondary_count
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrimaryCategory whereUpdatedAt($value)
 */
	class PrimaryCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $information
 * @property int $price
 * @property int $is_selling
 * @property int|null $sort_order
 * @property int $shop_id
 * @property int $secondary_category_id
 * @property int|null $image1
 * @property int|null $image2
 * @property int|null $image3
 * @property int|null $image4
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\SecondaryCategory $category
 * @property-read \App\Models\Image|null $imageFirst
 * @property-read \App\Models\Image|null $imageFourth
 * @property-read \App\Models\Image|null $imageSecond
 * @property-read \App\Models\Image|null $imageThird
 * @property-read \App\Models\Shop $shop
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stock[] $stock
 * @property-read int|null $stock_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSecondaryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SecondaryCategory
 *
 * @property int $id
 * @property string $name
 * @property int $sort_order
 * @property int $primary_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PrimaryCategory|null $primary
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory wherePrimaryCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SecondaryCategory whereUpdatedAt($value)
 */
	class SecondaryCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Shop
 *
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string $information
 * @property string $filename
 * @property int $is_selling
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Owner $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @property-read int|null $product_count
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereIsSelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shop whereUpdatedAt($value)
 */
	class Shop extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stock
 *
 * @property int $id
 * @property int $product_id
 * @property int $type
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stock whereUpdatedAt($value)
 */
	class Stock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

