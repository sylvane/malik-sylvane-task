<?php
require_once('params.php');


$argv_bin_count = ($argv[1] ?? null) ?: null;
if(is_null($argv_bin_count)) return;

$argv_start_index = $argv[2] ?? null;
if(!is_numeric($argv_start_index) || $argv_start_index < 0)
  throw new InvalidArgumentException('Invalid start index: '.$argv_start_index);

$start_index = $argv_start_index;

if(!is_numeric($argv_bin_count) || $argv_bin_count <= 0)
  throw new InvalidArgumentException('Invalid bin count: '.$argv_bin_count);

$aisle_bin_count = intval($argv_bin_count);
echo "\$aisle_bin_count: {$aisle_bin_count}\n";

$argv_requested_bins = ($argv[3] ?? null) ?: null;
if(!is_null($argv_requested_bins))
{
  $requested_bins = explode(',', $argv_requested_bins);
  echo "\$$requested_bins: {$requested_bins}\n";
}

$aisle_count = 4;

$new_edges = [];

function add_edge(array &$new_edges, int $a, int $b) {
  $new_edges[] = [ $a, $b ];

  // Debugging
  global $edges, $aisle_bin_count;
  if($aisle_bin_count === 11
    && ($edges[count($new_edges) - 1][0] !== $a
    || $edges[count($new_edges) - 1][1] !== $b))
  {
    echo "add_edge($a, $b) @ Caller Line #".debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[0]['line']."\n";
    echo "Expected: (".$edges[count($new_edges) - 1][0].', '.$edges[count($new_edges) - 1][1].")\n";
    echo "\n";
    exit;
  }
}

$aisle_cells_count = ($aisle_count * ($aisle_bin_count + 2));
$bottom_row_connectors_start_index = $aisle_cells_count;
$top_row_connectors_start_index = $bottom_row_connectors_start_index + (2 * ($aisle_count - 1));
$top_row_connectors_end_index = $bottom_row_connectors_start_index + ($aisle_count * 3) - 1;

foreach(range(0, $aisle_count - 1) as $aisle_index) {
  $aisle_start = ($aisle_index * $aisle_bin_count) + ($aisle_index * 2);
  foreach (range(0, $aisle_bin_count + 1) as $row_index) {
    $cell_index = $aisle_start + $row_index;
    // Bottom Row
    if($row_index === 0) {
      add_edge($new_edges, $cell_index, $cell_index + 1);
      if($aisle_index !== 0)
        add_edge($new_edges,
          $cell_index,
          $aisle_cells_count + ($aisle_index * 2) - 1
        );
      if($aisle_index !== $aisle_count - 1)
        add_edge($new_edges,
          $cell_index,
          $aisle_cells_count + ($aisle_index * 2)
        );
    }
    else {
      // Add Bottom Edge
      add_edge($new_edges,
        $cell_index,
        $cell_index - 1
      );
      // Top Row
      if($row_index === $aisle_bin_count + 1) {
        if($aisle_index !== 0)
          // Add Left Edge
          add_edge($new_edges,
            $cell_index,
            ($top_row_connectors_start_index - 1) + ($aisle_index * 2)
          );
        if($aisle_index !== $aisle_count - 1)
          // Add Right Edge
          add_edge($new_edges,
            $cell_index,
            $top_row_connectors_start_index + ($aisle_index * 2)
          );
      }

      // Add Top Edge
      else
        add_edge($new_edges,
          ($aisle_index * $aisle_bin_count + ($aisle_index * 2)) + $row_index,
          ($aisle_index * $aisle_bin_count + ($aisle_index * 2)) + $row_index + 1
        );
    }
  }
}

foreach(range($bottom_row_connectors_start_index, $top_row_connectors_start_index - 1) as $row_pos_idx => $row_connector_index) {
  $row_pair_idx = floor($row_pos_idx / 2);
  // Left-Side Rack End
  if ($row_pos_idx % 2 === 0) {
    add_edge($new_edges, $row_connector_index, ($aisle_bin_count + 2) * $row_pair_idx);
    add_edge($new_edges, $row_connector_index, $row_connector_index + 1);
    // Right-Side Rack End
  } else {
    add_edge($new_edges, $row_connector_index, ($aisle_bin_count + 2) * ($row_pair_idx + 1));
    add_edge($new_edges, $row_connector_index, $row_connector_index - 1);
  }
}

foreach(range($top_row_connectors_start_index, $top_row_connectors_end_index) as $row_pos_idx => $row_connector_index) {
  $row_pair_idx = floor($row_pos_idx / 2);
  // Left-Side Rack End
  if ($row_pos_idx % 2 === 0) {
    add_edge($new_edges, $row_connector_index, (($aisle_bin_count + 1) * ($row_pair_idx + 1)) + $row_pair_idx);
    add_edge($new_edges, $row_connector_index, $row_connector_index + 1);
    // Right-Side Rack End
  } else {
    add_edge($new_edges, $row_connector_index, ($aisle_bin_count + 2) * ($row_pair_idx + 2) - 1);
    add_edge($new_edges, $row_connector_index, $row_connector_index - 1);
  }
}

// echo json_encode($new_edges)."\n\n".json_encode($edges)."\n"; exit;
$edges = $new_edges;
$num_nodes = $top_row_connectors_end_index + 1;

function add_bin_mapping(&$new_bin_mapping, $bin_id, $mapping) {
  $new_bin_mapping[$bin_id] = $mapping;
  global $bin_mapping, $aisle_bin_count;
  if($aisle_bin_count === 11
    && (!isset($bin_mapping[$bin_id]) || $bin_mapping[$bin_id] !== $mapping))
  {
    echo "add_bin_mapping($bin_id, $mapping) @ Caller Line #".debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[0]['line']."\n";
    echo "Expected: ({$bin_id}, ".($bin_mapping[$bin_id] ?? 'Unset').")\n";
    echo "\n";
    exit;
  }
}

$new_bin_mapping = [];
$alphabet = range('A', 'Z');
foreach(range(0, $aisle_count - 1) as $aisle_index) {
  // Debugging
  echo "----------------------------\n";
  foreach(range(1, $aisle_bin_count) as $bin_index) {
    add_bin_mapping($new_bin_mapping, $alphabet[$aisle_index * 2] . $bin_index, $bin_index + (($aisle_bin_count + 2) * $aisle_index));
    if($aisle_index < $aisle_count - 1)
      add_bin_mapping($new_bin_mapping, $alphabet[($aisle_index * 2) + 1] . $bin_index, $bin_index + (($aisle_bin_count + 2) * $aisle_index));
  }
}

$new_bin_mapping['start'] = $start_index;

// echo json_encode($new_bin_mapping)."\n\n".json_encode($bin_mapping)."\n"; exit;
$bin_mapping = $new_bin_mapping;