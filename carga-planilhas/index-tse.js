const { readFileSync, writeFileSync } = require('fs')
const { resolve } = require('path')

const year = 2012

const data = readFileSync(resolve(__dirname, 'tse', `${year}.csv`), 'latin1')

const rows = data.split('\n')

const dataRows = rows.slice(1, rows.length - 1).map(row => row.replace(/\r/g, '').replace(/"/g, '').split(';'))

const validHeaders = [
	{p: 2, o: 'ANO_ELEICAO', n: 'year'},
	{p: 5, o: 'NR_TURNO', n: 'round'},
	{p: 10, o: 'SG_UF', n: 'state_initials', d: "'"},
	{p: 14, o: 'NM_MUNICIPIO', n: 'city_name', d: "'"},
	{p: 17, o: 'DS_CARGO', n: 'job', d: "'"},
	{p: 19, o: 'NR_CANDIDATO', n: 'number'},
	{p: 20, o: 'NM_CANDIDATO', n: 'name', d: "'"},
	{p: 21, o: 'NM_URNA_CANDIDATO', n: 'nickname', d: "'"},
	{p: 24, o: 'DS_SITUACAO_CANDIDATURA', n: 'situation_description', d: "'"},
	{p: 26, o: 'DS_DETALHE_SITUACAO_CAND', n: 'situation_detail', d: "'"},
	{p: 28, o: 'NR_PARTIDO', n: 'party_number'},
	{p: 29, o: 'SG_PARTIDO', n: 'party', d: "'"},
	{p: 30, o: 'NM_PARTIDO', n: 'party_name', d: "'"},
	{p: 35, o: 'DS_SIT_TOT_TURNO', n: 'situation_candidate', d: "'"},
	{p: 37, o: 'QT_VOTOS_NOMINAIS', n: 'votes'}
]

const baseQuery = 'INSERT INTO elections (year, round, state_initials, city_name, job, number, name, nickname, situation_description, situation_detail, party_number, party, party_name, situation_candidate, votes) VALUES '
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

writeFileSync(`sql/tse-${year}.sql`, query.substr(0, query.length - 2))

console.log(`${year} CONCLUÍDO!!!!!!!!!!!!!`)
