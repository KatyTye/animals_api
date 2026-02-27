import contentJSON from "../assets/content.json"

export default function Methods() {

	return (
		<>
			{
				contentJSON.map((folder, idx) => {
					return <section className={"content-section " + folder.name.replace(" ", "-")}
						id={"folder-" + folder.name.replace(" ", "-")} key={"folder-" + folder.name}>
						<h3 className="content-section__title">{folder.name}</h3>
						<div className="content-section__method-holder">
							<p>METHODS:</p>
							<ul className="content-section__methods">
								{folder.methods.map((method) => {
									return <li className={"content-section__methods " + method}
										key={"folder-" + folder.name + "methods-" + method}>
										{method}
									</li>
								})}
							</ul>
						</div>

						{
							folder.endpoints.map((method, idx) => {
								return <div id={method.name.replace(" ", "-")} className="content-section__endpoint-holder" key={idx + "-method-" + method.url}>
									<p className="content-section__endpoint-title">
										<span>
											{method.name}
										</span>

										<span className={method.method}>
											{method.method}
										</span>
									</p>

									{(folder.req == true &&
										<p className="auth">
											requires admin authorization
										</p>
									)}

									<p className="content-section__endpoint">
										{method.url}
									</p>

									{(method.fields.length != 0 && <p className='content-section__endpoint-fields-title'>
										Required Fields
									</p>)}

									{
										(
											method.fields.length != 0 &&
											<ul className="content-section__endpoint-fields">
												{method.fields.map((name) => {
													return <li key={idx + "-" + name + "-" + method.name}>
														{name}
													</li>
												})}
											</ul>
										)
									}
								</div>
							})
						}
					</section>
				})
			}
		</>
	)
}