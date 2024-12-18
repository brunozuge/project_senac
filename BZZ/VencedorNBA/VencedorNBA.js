function highlightTopTeam() {
    const rows = document.querySelectorAll('#champions-table tbody tr');
    let maxTitles = 0;
    let topTeamRow;

    rows.forEach(row => {
        const titles = parseInt(row.cells[1].textContent);
        if (titles > maxTitles) {
            maxTitles = titles;
            topTeamRow = row;
        }
    });

    rows.forEach(row => row.classList.remove('highlight'));

    if (topTeamRow) {
        topTeamRow.classList.add('highlight');
    }
}

function showDetails(team) {
    const teamNameElement = document.getElementById('team-name');
    const championshipYearsElement = document.getElementById('championship-years');
    const teamFactsElement = document.getElementById('team-facts');
    
    let teamName = '';
    let championshipYears = '';
    let teamFacts = '';

    switch (team) {
        case 'lakers':
            teamName = 'Los Angeles Lakers';
            championshipYears = 'Títulos: 1949, 1950, 1952, 1953, 1954, 1972, 1980, 1982, 1985, 1987, 1988, 2000, 2001, 2002, 2009, 2010, 2020';
            teamFacts = 'Curiosidade: Os Lakers são conhecidos por suas dinastias em diferentes épocas, incluindo as eras de Magic Johnson e Kobe Bryant.';
            break;
        case 'celtics':
            teamName = 'Boston Celtics';
            championshipYears = 'Títulos: 1957, 1959, 1960, 1961, 1962, 1963, 1964, 1965, 1966, 1968, 1969, 1974, 1976, 1981, 1984, 1986, 2008';
            teamFacts = 'Curiosidade: O Boston Celtics dominou a NBA nos anos 60, vencendo 11 títulos em 13 temporadas.';
            break;
        case 'warriors':
            teamName = 'Golden State Warriors';
            championshipYears = 'Títulos: 1947, 1956, 1975, 2015, 2017, 2018, 2022';
            teamFacts = 'Curiosidade: Os Warriors redefiniram o basquete moderno com seu estilo de jogo rápido e arremessos de três pontos sob o comando de Stephen Curry.';
            break;
        case 'bulls':
            teamName = 'Chicago Bulls';
            championshipYears = 'Títulos: 1991, 1992, 1993, 1996, 1997, 1998';
            teamFacts = 'Curiosidade: Os Bulls dominaram os anos 90 com Michael Jordan, conquistando dois "three-peats" consecutivos.';
            break;
        case 'spurs':
            teamName = 'San Antonio Spurs';
            championshipYears = 'Títulos: 1999, 2003, 2005, 2007, 2014';
            teamFacts = 'Curiosidade: Os Spurs são conhecidos por sua consistência e o comando de Gregg Popovich, vencendo títulos em três décadas diferentes.';
            break;
        default:
            return;
    }

    teamNameElement.textContent = teamName;
    championshipYearsElement.textContent = championshipYears;
    teamFactsElement.textContent = teamFacts;

    document.getElementById('modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
