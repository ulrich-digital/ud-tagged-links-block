import { useEffect, useState } from "@wordpress/element";
import { useSelect } from "@wordpress/data";
import {
	TextControl,
	FormTokenField,
	SelectControl,
	Spinner,
	Button,
} from "@wordpress/components";

import { chevronDown, chevronRight } from "@wordpress/icons";
import { useBlockProps } from "@wordpress/block-editor";

const REST_NONCE = window.udTagLinkSettings?.nonce || "";

export default function Edit({ attributes, setAttributes }) {
	const { selectedPageId, selectedTags } = attributes;
	const blockProps = useBlockProps();
	const [showOptions, setShowOptions] = useState(false);

	// Globale Tags von REST laden
	const [globalTags, setGlobalTags] = useState([]);

	useEffect(() => {
		fetch("/wp-json/ud-shared/v1/tags", {
			headers: {
				"Content-Type": "application/json",
			},
			credentials: "same-origin", // ✅ das ist entscheidend
		})
			.then((res) => res.json())
			.then((tags) => {
				if (Array.isArray(tags)) {
					setGlobalTags(tags);
				}
			})
			.catch((error) => {
				console.warn("Fehler beim Laden der Tags:", error);
				setGlobalTags([]);
			});
	}, []);

	// Alle Seiten laden (Page/Post)
	const pages = useSelect((select) =>
		select("core").getEntityRecords("postType", "page", {
			per_page: -1,
			status: ["publish", "private"], // ← wichtig
		}),
	);

	return (
		<div {...blockProps}>

			<div className="tagged-links-block__row tagged-links-block__row--options-toggle">
			<h2 className="tagged-links-block__title">Automatische Links</h2>
				<Button
					variant="tertiary"
					size="small"
					icon={showOptions ? chevronDown : chevronRight}
					onClick={() => setShowOptions((v) => !v)}
				>
					{showOptions ? "Details" : "Details"}
				</Button>
			</div>

			{showOptions && (
				<>
					<div className="tagged-links-block__field field__page">
						<label className="tagged-links-block__label">
							Seite mit den Link-Blocks auswählen
						</label>
						{!pages ? (
							<Spinner />
						) : (
							<SelectControl
								value={selectedPageId || ""}
								options={[
									{
										label: "— Seite mit den Link-Blocks auswählen —",
										value: "",
									},
									...pages.map((page) => ({
										label:
											page.title.rendered ||
											`(ID ${page.id})`,
										value: page.id,
									})),
								]}
								onChange={(val) =>
									setAttributes({
										selectedPageId:
											parseInt(val, 10) || null,
									})
								}
								__next40pxDefaultSize={true}
								__nextHasNoMarginBottom={true}
							/>
						)}
					</div>

					<div className="tagged-links-block__field field__tags">
						<label className="tagged-links-block__label">
							Links mit folgenden Tags ausgeben
						</label>
						<FormTokenField
							suggestions={globalTags}
							value={selectedTags || []}
							onFocus={() => {
								fetch("/wp-json/ud-shared/v1/tags", {
									headers: {
										"Content-Type": "application/json",
									},
									credentials: "same-origin",
								})
									.then((res) => res.json())
									.then((tags) => {
										if (Array.isArray(tags)) {
											setGlobalTags(tags);
										}
									})
									.catch((err) =>
										console.warn(
											"❌ Fehler beim Nachladen der Tags:",
											err,
										),
									);
							}}
							onChange={(tags) =>
								setAttributes({ selectedTags: tags })
							}
							__next40pxDefaultSize={true}
							__nextHasNoMarginBottom={true}
						/>
					</div>
				</>
			)}
		</div>
	);
}
