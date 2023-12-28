const { readFileSync, writeFileSync } = require('fs')
const { resolve } = require('path')

const year = 2007

const data = readFileSync(resolve(__dirname, 'edu', `${year}.csv`), 'latin1')

const rows = data.split('\n')

const dataRows = rows.slice(1, rows.length - 1).map(row => row.replace(/\r/g, '').replace(/"/g, '').split(';'))

const validHeaders = [
	{p: 0, o: 'Ano', n: 'year'},
	{p: 1, o: 'Município', n: 'city_name', d: "'"},
	{p: 2, o: 'Ideb iniciais', n: 'state_initials', d: "'"},
	{p: 3, o: 'Ideb finais', n: 'state_finals', d: "'"}
]

const baseQuery = 'INSERT INTO education (year, city_name, ideb_initials, ideb_finals) VALUES '
let query = baseQuery
let iteraction = 1

for(let i = 0; i < dataRows.length; i++) {
	const dataRow = dataRows[i]
	const isLastRow = i === dataRows.length - 1
	const validColumns = dataRow.filter((_, index) => validHeaders.find(header => header.p === index))

	query += `(${validColumns.map((col, index) => validHeaders[index].d ? `${validHeaders[index].d}${col}${validHeaders[index].d}` : col).join(',')})`

	if(iteraction % 500 === 0 && !isLastRow) {
		query += `;\n\n${baseQuery}`
	} else {
		query += ',\n'
	}

	iteraction++
}

writeFileSync(`sql/edu-${year}.sql`, query.substr(0, query.length - 2))

console.log(`${year} CONCLUÍDO!!!!!!!!!!!!!`)
