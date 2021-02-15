<?php
namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\BeforeDateFilter;
use App\Nova\Filters\AfterDateFilter;
use App\Nova\Filters\UserIDFilter;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;




class Favorite extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Favorite::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['id', 'user_id', 'source', 'title'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['user'];

    
    public function fields(Request $request)
    {
        return [
        BelongsTo::make('User'),

        ID::make(__('ID') , 'id')
            ->sortable() ,

        Text::make('News Source', 'source')
            ->sortable()
            ->rules('required') ,

        Text::make('Article Title', 'title')
            ->sortable()
            ->rules('required') ,
        
        DateTime::make('Created At', 'created_at')
            ->sortable()
            ->rules('required')
            ->hideWhenCreating() ,

        DateTime::make('Updated At', 'updated_at')
            ->sortable()
            ->rules('required')
            ->hideWhenCreating(),

        Text::make('Article Description', 'description')
            ->rules('required') ,

        Text::make('URL To Article', 'url')
            ->rules('required') ,

        Text::make('Category', 'category')
            ->sortable()
            ->rules('required') ,

        Text::make('Country', 'country')
            ->sortable()
            ->rules('required') ,

        Text::make('Photo from Article', 'urlToImage')
            ->rules('required')
            ->hideFromIndex() ,
        
        Number::make('Posted Status', 'posted_status')
        ->rules('required'),
        
        
        ];
            
            
        
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new UserIDFilter,
            new BeforeDateFilter,
            new AfterDateFilter,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new DownloadExcel,
        ];
    }
}

