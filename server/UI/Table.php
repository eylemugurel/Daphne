<?php
/**
 * @file Table.php
 * Contains the `Table` class.
 *
 * @version 1.1
 * @date    December 14, 2019 (16:41)
 * @author  Eylem Ugurel
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Copyright (C) 2019 Eylem Ugurel. All rights reserved.
 */

namespace UI;

/**
 * Represents a table element.
 *
 * Example of a rendered code:
 *
 *     <table class="table table-striped table-bordered table-hover" width="100%">
 *         <thead>
 *             <tr>
 *                 <th>ID</th>
 *                 <th>Name</th>
 *             </tr>
 *         </thead>
 *     </table>
 */
class Table extends Element
{
	/**
	 * List of header cell contents.
	 */
	private $headerContents = array();

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct('table');
		$this->AddClass('table table-striped table-bordered table-hover');
		$this->SetAttribute('width', '100%');
	}

	/**
	 * Adds a new header cell content.
	 *
	 * @param string $headerContent The content of the header cell.
	 * @return This instance.
	 */
	public function AddHeader($headerContent)
	{
		array_push($this->headerContents, $headerContent);
		return $this;
	}

	/**
	 * @copydoc Element::Render
	 */
	public function Render()
	{
		$this->RemoveChildren();
		if (count($this->headerContents) > 0) {
			$head = new TableHead;
			$row = new TableRow;
			foreach ($this->headerContents as $headerContent)
				$row->AddChild(new TableHeaderCell($headerContent));
			$head->AddChild($row);
			$this->AddChild($head);
		}
		parent::Render();
	}
}
?>