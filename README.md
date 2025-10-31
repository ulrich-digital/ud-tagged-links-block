# UD Block: Tag-basierte Links

Dynamischer Block zur Anzeige aller **UD-Link-Blöcke**, die mit bestimmten **Tags** verknüpft sind.
Er ermöglicht es, thematische oder kategoriebasierte Linklisten automatisch zusammenzustellen – ohne doppelte Pflege der Inhalte.


## Funktionen

- **Automatische Verknüpfung über Tags**
  - Zeigt alle `ud-link-block`-Instanzen an, die die gewählten Tags besitzen
  - Erkennt auch verschachtelte Link-Blöcke innerhalb von Gruppen, Spalten oder Cover-Blöcken

- **Seitenbezogene Ausgabe**
  - Standardmässig werden die Link-Blöcke der aktuellen Seite verwendet
  - Optional kann eine andere Seite gewählt werden, um deren Link-Blöcke anzuzeigen
  - Ideal für themenspezifische Übersichtsseiten oder Sammlungen

- **Abhängigkeiten:**
  - Benötigt das Plugin **`ud-link-block`** (liefert die eigentlichen Link-Instanzen)
  - Setzt **`ud-shared-api`** voraus (liefert REST-Endpunkte für Seiten- und Tag-Auswahl)
- **Verarbeitet:**
  - `ud/link-block` (direkt oder verschachtelt in `core/group`, `core/columns`, `core/cover`)


## Screenshots

![Frontend-Ansicht](./assets/ud-tagged-links-block.png)
*Ansicht im Frontend*

![Editor-Ansicht](./assets/editor-view.png)
*Ansicht im Editor*



## Autor

[ulrich.digital gmbh](https://ulrich.digital)


## Lizenz

GPL v2 or later
[https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)


