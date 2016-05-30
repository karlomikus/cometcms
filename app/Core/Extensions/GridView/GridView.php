<?php
namespace Comet\Core\Extensions\GridView;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Generate the table HTML
 */
class GridView
{
    /**
     * Grid data resolver
     * @var EloquentGridViewAdapter
     */
    protected $data;

    /**
     * Grid columns
     * @var array
     */
    protected $columns = [];

    /**
     * Grid headers
     * @var array
     */
    protected $headers = [];

    /**
     * Grid column attributes
     * @var array
     */
    protected $attributes = [];

    /**
     * Current page number
     * @var int
     */
    protected $page;

    /**
     * Rows per table
     * @var int
     */
    protected $limit;

    /**
     * Base URL
     * @var string
     */
    protected $basePath;

    public function __construct($data, $page, $limit)
    {
        $this->data = $data;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function setColumn($label, $name)
    {
        $this->columns[$name] = $label;

        return $name;
    }

    public function assignAttribute($col, $attr)
    {
        $this->attributes[$col] = $attr;
    }

    public function setBasePath($path)
    {
        $this->basePath = $path;
    }

    public function setHeader($colName, $link)
    {
        $this->headers[$colName]['link'] = $link;
    }

    public function make($gridID)
    {
        $table = [];
        $table[] = '<table id="'. $gridID .'" class="table table-hover table-grid table-admin">';

        // HEADER
        $table[] = "<thead>";
        $table[] = "<tr>";
        foreach ($this->columns as $id => $label) {
            $table[] = $this->resolveColumnHeader($id, $label);
        }
        $table[] = "</tr>";
        $table[] = "</thead>";

        // BODY
        $table[] = "<tbody>";
        foreach ($this->getData() as $row) {
            $table[] = "<tr>";
            foreach ($this->columns as $colKey => $colLabel) {
                $table[] = $this->resolveColumnData($colKey, $row);
            }
            $table[] = "</tr>";
        }
        $table[] = "</tbody>";

        // FOOTER
        $colspan = count($this->columns) - 1;
        $table[] = "<tfoot>";
        $table[] = "<tr>";
        $table[] = "<td colspan='$colspan'>";
        $table[] = $this->getData()->render();
        $table[] = "<td>";
        $table[] = "</tr>";
        $table[] = "</tfoot>";

        $table[] = '</table>';

        return implode(PHP_EOL, $table);
    }

    private function resolveColumnData($colKey, $row)
    {
        $col = [];
        if (array_key_exists($colKey, $this->attributes)) {
            if (is_callable($this->attributes[$colKey])) {
                $col[] = "<td>". call_user_func($this->attributes[$colKey], $row) ."</td>";
            } else {
                $col[] = "<td>". $row->{$this->attributes[$colKey]} ."</td>";
            }
        } else {
            $col[] = "<td></td>";
        }

        return implode(PHP_EOL, $col);
    }

    private function resolveColumnHeader($id, $label)
    {
        $template = '<th><a href="{link}">{label} {caret}</a></th>';

        if (array_key_exists($id, $this->headers)) {
            $addonLink = $this->headers[$id]['link'];
            $link = $this->basePath . '?' . $this->buildQueryLink(['order' => $addonLink]);
            $caret = $this->reverseDireactionCaret();

            $template = str_replace('{label}', $label, $template);
            $template = str_replace('{link}', $link, $template);
            $template = str_replace('{caret}', $caret, $template);
        }
        else {
            $template = '<th>' . $label . '</th>';
        }

        return $template;
    }

    private function getData()
    {
        $total = $this->data->total();
        $data = $this->data->chunk($this->page, $this->limit);

        $paginatedData = new LengthAwarePaginator($data, $total, $this->limit, $this->page);
        $paginatedData->setPath($this->basePath);

        return $paginatedData;
    }

    private function buildQueryLink(array $append)
    {
        $allowed = ['page', 'order', 'search', 'limit', 'dir'];

        $newQuery = array_merge($_GET, $append);

        $data = [];
        foreach ($newQuery as $queryKey => $queryVal) {
            if (in_array($queryKey, $allowed)) {
                $data[$queryKey] = $queryVal;
            }
        }

        $basePath = $this->basePath;
        $query = http_build_query($data);

        return $query;
    }

    private function reverseDireactionCaret()
    {
        $caret = isset($_GET['dir']) ? $_GET['dir'] : 'asc';
        if ($caret !== 'asc' || $caret !== 'desc') {
            return;
        }

        $ascCaret = '<i class="fa fa-caret-up">';
        $descCaret = '<i class="fa fa-caret-down">';

        return $caret === 'asc' ? $descCaret : $ascCaret;
    }
}
