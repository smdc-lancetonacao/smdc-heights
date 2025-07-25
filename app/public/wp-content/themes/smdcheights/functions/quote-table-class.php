<?php
// functions/quote-table-class.php
if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Quote_Request_List_Table extends WP_List_Table
{

    public function __construct()
    {
        parent::__construct([
            'singular' => 'Quote Request',
            'plural'   => 'Quote Requests',
            'ajax'     => false
        ]);
    }

    public function get_columns()
    {
        return [
            'cb'      => '<input type="checkbox" />',
            'name'    => 'Name',
            'email'   => 'Email',
            'phone'   => 'Phone',
            'property' => 'Property',
            'message' => 'Message',
            'country' => 'Country',
            'date'    => 'Date Submitted'
        ];
    }

    public function get_sortable_columns()
    {
        return [
            'name'  => ['name', false],
            'email' => ['email', false],
            'date'  => ['date', true]
        ];
    }

    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="quote_ids[]" value="%s" />', $item['id']);
    }

    public function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    public function get_bulk_actions()
    {
        return ['delete' => 'Delete'];
    }

    public function prepare_items()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'quote_requests';

        $search = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        $orderby = !empty($_REQUEST['orderby']) ? sanitize_sql_orderby($_REQUEST['orderby']) : 'date';
        $order = !empty($_REQUEST['order']) ? sanitize_text_field($_REQUEST['order']) : 'DESC';

        $query = "SELECT * FROM $table";
        if ($search) {
            $query .= $wpdb->prepare(" WHERE name LIKE %s OR email LIKE %s", "%$search%", "%$search%");
        }
        $query .= " ORDER BY $orderby $order";

        $items = $wpdb->get_results($query, ARRAY_A);

        if (empty($items)) {
            error_log("No items found. Query: $query");
        }

        $per_page = 20;
        $current_page = $this->get_pagenum();
        $total_items = count($items);
        $this->items = array_slice($items, ($current_page - 1) * $per_page, $per_page);

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ]);
    }

    public function display_rows()
    {
        foreach ($this->items as $item) {
            echo '<tr>';
            foreach ($this->get_columns() as $column_name => $column_display_name) {
                if ($column_name === 'cb') {
                    echo '<th scope="row" class="check-column">';
                    echo $this->column_cb($item);
                    echo '</th>';
                } else {
                    echo '<td>' . esc_html($item[$column_name]) . '</td>';
                }
            }
            echo '</tr>';
        }
    }
}

// Admin Page Setup
add_action('admin_menu', 'register_quote_admin_page');
function register_quote_admin_page()
{
    add_menu_page('Quote Requests', 'Quote Requests', 'manage_options', 'quote-requests', 'render_quote_requests_page', 'dashicons-media-text', 30);
}

function render_quote_requests_page()
{
    echo '<div class="wrap">';
    echo '<h1 class="wp-heading-inline">Quote Requests</h1>';
    // echo '<a href="' . esc_url(add_query_arg(['export' => 'csv'])) . '" class="page-title-action">Export CSV</a>';

    $list_table = new Quote_Request_List_Table();

    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        export_quote_csv();
    }

    $list_table->prepare_items();
    echo '<form method="get">';
    echo '<input type="hidden" name="page" value="' . esc_attr($_REQUEST['page']) . '" />';
    $list_table->search_box('Search Quotes', 'quote_search');
    $list_table->display();
    echo '</form>';
    echo '</div>';
}

function export_quote_csv()
{
    global $wpdb;
    $table = $wpdb->prefix . 'quote_requests';
    $rows = $wpdb->get_results("SELECT * FROM $table ORDER BY date DESC", ARRAY_A);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="quote-requests.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Email', 'Phone', 'property', 'Country', 'Date']);

    foreach ($rows as $row) {
        fputcsv($output, [
            $row['name'],
            $row['email'],
            $row['phone'],
            $row['property'],
            $row['country'],
            $row['date']
        ]);
    }
    fclose($output);
    exit;
}
