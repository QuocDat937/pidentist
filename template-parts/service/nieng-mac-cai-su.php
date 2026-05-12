<?php
/**
 * Pi Dentist — Service Detail: Niềng mắc cài sứ
 *
 * Template part chuyên sâu cho /dich-vu/nieng-mac-cai-su/.
 * Render: TOC sidebar + rich content sections.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$phone = esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) );
?>

<div class="service-detail__layout">

	<!-- ─── Table of Contents (sticky sidebar) ──────────────── -->
	<aside class="service-toc reveal" aria-label="Mục lục bài viết">
		<p class="service-toc__title">Mục lục</p>
		<nav class="service-toc__list">
			<a href="#tong-quan" class="service-toc__link">Tổng quan</a>
			<a href="#cau-tao" class="service-toc__link">Cấu tạo & Nguyên lý</a>
			<a href="#uu-diem" class="service-toc__link">Ưu điểm nổi bật</a>
			<a href="#phu-hop" class="service-toc__link">Ai nên niềng?</a>
			<a href="#quy-trinh" class="service-toc__link">Quy trình điều trị</a>
			<a href="#so-sanh" class="service-toc__link">So sánh phương pháp</a>
			<a href="#cam-ket" class="service-toc__link">Cam kết tại Pi</a>
		</nav>
	</aside>

	<!-- ─── Main Content Column ─────────────────────────────── -->
	<div class="service-detail__content">

		<!-- ══ Section: Tổng quan ══════════════════════════════ -->
		<section class="service-content-section reveal" id="tong-quan">
			<h2 class="service-section-heading">Tổng quan về niềng mắc cài sứ</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Niềng mắc cài sứ (Ceramic Braces) là phương pháp chỉnh nha sử dụng <strong>mắc cài bằng sứ/gốm y tế (ceramic)</strong> có màu trắng trong mờ, gần giống màu răng tự nhiên. Đây là sự kết hợp hoàn hảo giữa hiệu quả điều trị của mắc cài truyền thống và yếu tố thẩm mỹ vượt trội — giúp người niềng tự tin hơn trong giao tiếp hàng ngày.
				</p>
				<p>
					Tại Pi Dentist, chúng tôi sử dụng <strong>mắc cài sứ polycrystalline thế hệ mới</strong> — trong suốt hơn, bền hơn và ít bị đổi màu theo thời gian. Kết hợp với dây cung tooth-colored (dây trắng) và công nghệ scan 3D iTero, mỗi ca niềng sứ đều được thiết kế chính xác từng chi tiết, mang lại kết quả tối ưu cả về chức năng lẫn thẩm mỹ.
				</p>
			</div>

			<!-- Highlight box -->
			<div class="service-highlight-box">
				<p class="service-highlight-box__title">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
					Xu hướng niềng thẩm mỹ
				</p>
				<p>
					Theo khảo sát của Hiệp hội Chỉnh nha Thế giới (WFO), nhu cầu niềng răng thẩm mỹ tăng <strong>hơn 40%</strong> trong 5 năm gần đây, đặc biệt ở nhóm người trưởng thành 25-45 tuổi. Mắc cài sứ là lựa chọn phổ biến nhất cho những ai muốn <strong>hiệu quả như kim loại nhưng thẩm mỹ vượt trội hơn</strong>.
				</p>
			</div>
		</section>

		<!-- ══ Section: Cấu tạo & Nguyên lý ═══════════════════ -->
		<section class="service-content-section reveal" id="cau-tao">
			<h2 class="service-section-heading">Cấu tạo và nguyên lý hoạt động</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Hệ thống niềng mắc cài sứ cũng gồm 4 thành phần chính như mắc cài kim loại, nhưng được tối ưu hóa về mặt thẩm mỹ:
				</p>
			</div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="8" width="18" height="8" rx="2"/><circle cx="8" cy="12" r="1.5"/><circle cx="16" cy="12" r="1.5"/></svg>
					</div>
					<div>
						<h4>Mắc cài sứ (Ceramic Bracket)</h4>
						<p>Miếng sứ/gốm y tế trong mờ, màu trắng ngà gần giống màu răng tự nhiên. Gắn trực tiếp lên bề mặt răng, gần như không nhìn thấy khi giao tiếp thông thường.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12h20"/><circle cx="6" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="18" cy="12" r="2"/></svg>
					</div>
					<div>
						<h4>Dây cung (Archwire)</h4>
						<p>Có thể sử dụng dây cung trắng (tooth-colored archwire) phủ lớp coating trắng, tăng tính thẩm mỹ tổng thể so với dây kim loại truyền thống.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
					</div>
					<div>
						<h4>Thun liên hàm (Elastics)</h4>
						<p>Dây thun trong suốt kết nối hàm trên và hàm dưới, hỗ trợ điều chỉnh khớp cắn. Thun trong giúp duy trì tổng thể thẩm mỹ của hệ thống niềng sứ.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 12h16"/><path d="M4 6h16"/><path d="M4 18h16"/></svg>
					</div>
					<div>
						<h4>Khâu & Phụ kiện</h4>
						<p>Band (khâu), hook, spring — các phụ kiện hỗ trợ tạo lực bổ sung cho các ca phức tạp. Một số phụ kiện có phiên bản tooth-colored để đồng bộ thẩm mỹ.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ưu điểm nổi bật ═══════════════════════ -->
		<section class="service-content-section reveal" id="uu-diem">
			<h2 class="service-section-heading">Ưu điểm nổi bật</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
					</div>
					<div>
						<h4>Thẩm mỹ cao</h4>
						<p>Mắc cài sứ trong mờ, gần như không nhìn thấy khi giao tiếp — lựa chọn lý tưởng cho người đi làm, giao tiếp nhiều.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
					</div>
					<div>
						<h4>Hiệu quả tương đương kim loại</h4>
						<p>Xử lý được hầu hết các ca chỉnh nha từ trung bình đến phức tạp, cho kết quả điều trị tương đương mắc cài kim loại.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<div>
						<h4>Không gây dị ứng</h4>
						<p>Sứ/gốm y tế (ceramic) có tính tương thích sinh học cao (biocompatible), không gây kích ứng nướu hay dị ứng kim loại.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 9V5a3 3 0 0 0-6 0v4"/><rect x="2" y="9" width="20" height="13" rx="2"/><circle cx="12" cy="16" r="1"/></svg>
					</div>
					<div>
						<h4>Tự tin khi giao tiếp</h4>
						<p>Không còn tự ti về nụ cười "sắt" — mắc cài sứ giúp bạn thoải mái nói chuyện, chụp ảnh và tham gia các sự kiện xã hội.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ai nên niềng? ═════════════════════════ -->
		<section class="service-content-section reveal" id="phu-hop">
			<h2 class="service-section-heading">Ai nên niềng mắc cài sứ?</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Niềng mắc cài sứ đặc biệt phù hợp với những ai quan tâm đến thẩm mỹ trong suốt quá trình điều trị:</p>
			</div>

			<div class="service-suited-list">
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người trưởng thành quan tâm đến thẩm mỹ khi niềng răng
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người đi làm, giao tiếp nhiều, thường xuyên gặp đối tác/khách hàng
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Muốn hiệu quả điều trị tương đương kim loại nhưng thẩm mỹ hơn
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Ca phức tạp (hô, móm, khớp cắn sâu) không phù hợp niềng trong suốt
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Dị ứng hoặc nhạy cảm với kim loại (nickel)
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Thanh thiếu niên từ 12 tuổi muốn niềng "kín đáo" hơn
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người hoạt động trong lĩnh vực nghệ thuật, truyền thông, giáo dục
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Sẵn sàng đầu tư thêm chi phí để có trải nghiệm niềng thẩm mỹ hơn
				</div>
			</div>
		</section>

		<!-- ══ Section: Quy trình điều trị ════════════════════ -->
		<section class="service-content-section reveal" id="quy-trinh">
			<h2 class="service-section-heading">Quy trình niềng mắc cài sứ tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Mỗi ca niềng tại Pi Dentist đều tuân theo quy trình <strong>5 bước chuẩn hóa</strong>, được cá nhân hóa theo tình trạng răng của từng bệnh nhân:</p>
			</div>

			<div class="service-process-steps">
				<div class="service-step">
					<div class="service-step__number">1</div>
					<div class="service-step__content">
						<p class="service-step__title">Tư vấn & Chẩn đoán kỹ thuật số</p>
						<p class="service-step__desc">Bác sĩ khám tổng quát, chụp X-quang panoramic + cephalometric, scan 3D iTero, phân tích cấu trúc xương hàm và lên kế hoạch điều trị chi tiết.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">2</div>
					<div class="service-step__content">
						<p class="service-step__title">Lên phác đồ điều trị cá nhân hóa</p>
						<p class="service-step__desc">Dựa trên dữ liệu 3D, bác sĩ mô phỏng kết quả dự kiến, tính toán thời gian, chi phí và phương án tối ưu. Bệnh nhân được xem trước kết quả trên màn hình.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">3</div>
					<div class="service-step__content">
						<p class="service-step__title">Chuẩn bị & Gắn mắc cài sứ</p>
						<p class="service-step__desc">Vệ sinh răng miệng, điều trị bệnh lý nền nếu có (sâu răng, viêm nướu). Gắn mắc cài sứ ceramic lên từng răng theo vị trí đã tính toán, kết hợp dây cung trắng nếu bệnh nhân lựa chọn.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">4</div>
					<div class="service-step__content">
						<p class="service-step__title">Tái khám định kỳ (mỗi 4-6 tuần)</p>
						<p class="service-step__desc">Bác sĩ kiểm tra tiến trình, thay dây cung, điều chỉnh lực kéo. Mỗi lần tái khám kéo dài 15-30 phút, theo dõi sát sao từng milimet dịch chuyển.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">5</div>
					<div class="service-step__content">
						<p class="service-step__title">Tháo mắc cài & Duy trì kết quả</p>
						<p class="service-step__desc">Tháo mắc cài sứ, đánh bóng răng, lắp hàm duy trì (retainer) để cố định kết quả. Bác sĩ hẹn tái khám định kỳ 3-6 tháng để theo dõi lâu dài.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: So sánh phương pháp ═══════════════════ -->
		<section class="service-content-section reveal" id="so-sanh">
			<h2 class="service-section-heading">So sánh với các phương pháp niềng khác</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Bảng so sánh nhanh giúp bạn hiểu rõ sự khác biệt giữa niềng mắc cài sứ và các phương pháp chỉnh nha phổ biến khác:</p>
			</div>

			<div class="service-comparison-table-wrap">
				<table class="service-comparison-table">
					<thead>
						<tr>
							<th>Tiêu chí</th>
							<th>Mắc cài kim loại</th>
							<th class="highlight-col">Mắc cài sứ</th>
							<th>Niềng trong suốt</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Hiệu quả điều trị</td>
							<td>★★★★★</td>
							<td class="highlight-col"><strong>★★★★☆</strong></td>
							<td>★★★★☆</td>
						</tr>
						<tr>
							<td>Thẩm mỹ khi đeo</td>
							<td>★★☆☆☆</td>
							<td class="highlight-col"><strong>★★★★☆</strong></td>
							<td>★★★★★</td>
						</tr>
						<tr>
							<td>Chi phí</td>
							<td>Từ 25 triệu</td>
							<td class="highlight-col"><strong>Từ 35 triệu</strong></td>
							<td>Từ 50 triệu</td>
						</tr>
						<tr>
							<td>Thời gian điều trị</td>
							<td>18-30 tháng</td>
							<td class="highlight-col">18-30 tháng</td>
							<td>12-24 tháng</td>
						</tr>
						<tr>
							<td>Xử lý ca phức tạp</td>
							<td>Rất tốt</td>
							<td class="highlight-col"><strong>Tốt</strong></td>
							<td>Hạn chế</td>
						</tr>
						<tr>
							<td>Độ bền mắc cài</td>
							<td>Rất cao</td>
							<td class="highlight-col">Trung bình</td>
							<td>N/A</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>

		<!-- ══ Section: Cam kết tại Pi ════════════════════════ -->
		<section class="service-content-section reveal" id="cam-ket">
			<h2 class="service-section-heading">Cam kết khi niềng tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
					</div>
					<div>
						<h4>Bảo hành kết quả</h4>
						<p>Cam kết kết quả điều trị đúng như phác đồ đã thống nhất. Nếu chưa đạt — tiếp tục điều trị miễn phí.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
					</div>
					<div>
						<h4>Trả góp 0% lãi suất</h4>
						<p>Hỗ trợ trả góp linh hoạt lên đến 12 tháng qua thẻ tín dụng, giúp tối ưu ngân sách điều trị.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
					</div>
					<div>
						<h4>Chi phí minh bạch</h4>
						<p>Báo giá trọn gói từ đầu — không phát sinh, không chi phí ẩn. Bao gồm tái khám, thay dây, retainer.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
					</div>
					<div>
						<h4>Bác sĩ chuyên sâu phụ trách</h4>
						<p>Mỗi bệnh nhân được 1 bác sĩ chỉnh nha chuyên trách theo dõi từ đầu đến cuối — không chuyển tay.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Inline CTA ═════════════════════════════════════ -->
		<div class="service-inline-cta reveal">
			<h3>Sẵn sàng bắt đầu hành trình chỉnh nha?</h3>
			<p>Đặt lịch tư vấn miễn phí để được bác sĩ khám, chẩn đoán và lên phác đồ điều trị riêng cho bạn.</p>
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold">
				Đặt lịch tư vấn miễn phí
				<span aria-hidden="true">→</span>
			</a>
		</div>

	</div><!-- /.service-detail__content -->

</div><!-- /.service-detail__layout -->
