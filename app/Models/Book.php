<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 * @property int $id
 * @property string $title
 * @property string $publisher
 * @property string $author
 * @property string $genre
 * @property Carbon $publication_date
 * @property int $word_count
 * @property string $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static BookFactory factory($count = null, $state = [])
 * @method static Builder|Book filter(QueryFilter $filters)
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereAuthor($value)
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereGenre($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book wherePrice($value)
 * @method static Builder|Book wherePublicationDate($value)
 * @method static Builder|Book wherePublisher($value)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @method static Builder|Book whereWordCount($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'publisher',
        'author',
        'genre',
        'publication_date',
        'word_count',
        'price',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'word_count' => 'integer',
        'price' => 'decimal:2',
    ];

    protected array $filters = [
        'title',
    ];

    public function scopeFilter(Builder $builder, QueryFilter $filters): Builder
    {
        return $filters->apply($builder);
    }
}
