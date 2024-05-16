# Clickable Table

The HTML table that can edit by clicking on its cells.
Clickable Table is a simple web application that allows users to interact with a table by clicking on its cells. Users can edit the content of the cells, save the changes, or cancel the editing process.

Demo webpage available at https://art29405.github.io/clickable-table/

![](https://raw.githubusercontent.com/art29405/clickable-table/main/videogif.gif)

## Features

- Click on any cell in the table to activate editing mode.
- Edit the content of the cell using an input field.
- Save the changes made to the cell.
- Cancel the editing process if needed.
- Keyboard shortcuts for saving (Enter key) and canceling (Escape key).
- Dim other element for user to focus the input field in editing mode.
- Stick the table header when scrolling down.
- Text helper in editing mode.
- No additional dependencies or library required.
- Exclude some column from editing mode.
- Data handler backend via AJAX with POST method. (PHP or any as needed)
- Parse error text to Alert if error occur.
- Race condition prevention by compare value to database value before modify.

## Installation

1. Modify "data-handler" destination
2. Modify "AppName" in POST value
3. Each table row need uniqe id in tr tag, for example "<tr id='01'>"
4. Move "activeCell.innerText = newData" to under status200
5. Exclude editing column if needed (column count start from 0)
6. Modify remove-row script if needed

## Usage

1. Click on any cell in the table to activate editing mode.
2. Edit the content of the cell using the input field.
3. Press Enter to save the changes or Escape to cancel.

## Technologies Used

- HTML
- CSS
- JavaScript

## Version

-- Version: 0.1.0.20240509

- inital release

-- Version: 0.2.0.20240516

- Align text-helper and button to column
- Add header.innertext to POST dta 
- Add AppName in POST data for data-handler to handle many application
- Improve data-handler example file
- Click any table-header to sort
- Add ability to check data before modify value to prevent Race condition
- Add create row markup
- Add Filter input

## Known Issues

- There is currently no validation for input data.

## Roadmap

- Ability to exclude row from sorting.
- Function to create new row.

## Contributing

Contributions are welcome! If you have any suggestions or find any issues, please open an issue or submit a pull request.

## License

This project is licensed under the GNU General Public License (GPL) - see the license file for details.