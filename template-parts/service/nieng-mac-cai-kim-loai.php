<?php
/**
 * Pi Dentist — Service Detail: Niềng mắc cài kim loại
 *
 * Template part chuyên sâu cho /dich-vu/nieng-mac-cai-kim-loai/.
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
			<h2 class="service-section-heading">Tổng quan về niềng mắc cài kim loại</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Niềng mắc cài kim loại (Metal Braces) là phương pháp chỉnh nha <strong>lâu đời nhất và được ứng dụng rộng rãi nhất</strong> trên thế giới, với lịch sử phát triển hơn 100 năm. Đây là kỹ thuật sử dụng hệ thống mắc cài bằng thép không gỉ y tế gắn trực tiếp lên bề mặt răng, kết hợp với dây cung (archwire) để tạo lực dịch chuyển răng về vị trí mong muốn.
				</p>
				<p>
					Tại Pi Dentist, chúng tôi sử dụng <strong>mắc cài kim loại thế hệ mới</strong> — nhỏ gọn hơn 30% so với mắc cài truyền thống, giúp tăng thẩm mỹ và giảm cảm giác cộm khi đeo. Kết hợp với công nghệ scan 3D và phần mềm lên phác đồ điều trị kỹ thuật số, mỗi ca niềng đều được bác sĩ tính toán chính xác từng milimet dịch chuyển.
				</p>
			</div>

			<!-- Highlight box -->
			<div class="service-highlight-box">
				<p class="service-highlight-box__title">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
					Bạn biết không?
				</p>
				<p>
					Theo Hiệp hội Chỉnh nha Hoa Kỳ (AAO), niềng mắc cài kim loại vẫn chiếm <strong>hơn 70%</strong> tổng số ca chỉnh nha trên toàn cầu nhờ hiệu quả vượt trội trong điều trị các trường hợp từ đơn giản đến phức tạp.
				</p>
			</div>
		</section>

		<!-- ══ Section: Cấu tạo & Nguyên lý ═══════════════════ -->
		<section class="service-content-section reveal" id="cau-tao">
			<h2 class="service-section-heading">Cấu tạo và nguyên lý hoạt động</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Hệ thống niềng mắc cài kim loại gồm 4 thành phần chính, phối hợp tạo lực sinh học liên tục và có kiểm soát để dịch chuyển răng:
				</p>
			</div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="8" width="18" height="8" rx="2"/><circle cx="8" cy="12" r="1.5"/><circle cx="16" cy="12" r="1.5"/></svg>
					</div>
					<div>
						<h4>Mắc cài (Bracket)</h4>
						<p>Miếng kim loại nhỏ gắn trực tiếp lên bề mặt răng bằng keo nha khoa chuyên dụng. Mỗi mắc cài được thiết kế riêng cho từng vị trí răng.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12h20"/><circle cx="6" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="18" cy="12" r="2"/></svg>
					</div>
					<div>
						<h4>Dây cung (Archwire)</h4>
						<p>Dây kim loại đàn hồi luồn qua rãnh mắc cài, tạo lực kéo liên tục để dịch chuyển răng theo quỹ đạo đã lập trình.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
					</div>
					<div>
						<h4>Thun liên hàm (Elastics)</h4>
						<p>Dây thun kết nối hàm trên và hàm dưới, hỗ trợ điều chỉnh khớp cắn và tương quan giữa hai hàm.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 12h16"/><path d="M4 6h16"/><path d="M4 18h16"/></svg>
					</div>
					<div>
						<h4>Khâu & Phụ kiện</h4>
						<p>Band (khâu), hook, spring — các phụ kiện hỗ trợ tạo lực bổ sung cho các ca phức tạp như răng ngầm, hô, móm.</p>
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
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
					</div>
					<div>
						<h4>Hiệu quả cao nhất</h4>
						<p>Xử lý được hầu hết các trường hợp sai lệch khớp cắn, từ đơn giản đến cực kỳ phức tạp.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
					</div>
					<div>
						<h4>Chi phí hợp lý</h4>
						<p>Tiết kiệm hơn so với niềng sứ hoặc Invisalign mà vẫn đảm bảo kết quả điều trị tối ưu.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
					</div>
					<div>
						<h4>Kiểm soát chính xác</h4>
						<p>Bác sĩ có toàn quyền kiểm soát lực và hướng dịch chuyển, linh hoạt điều chỉnh theo từng giai đoạn.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<div>
						<h4>Độ bền vượt trội</h4>
						<p>Mắc cài kim loại có độ cứng cao, ít bị vỡ hoặc bong tróc trong suốt quá trình điều trị.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ai nên niềng? ═════════════════════════ -->
		<section class="service-content-section reveal" id="phu-hop">
			<h2 class="service-section-heading">Ai nên niềng mắc cài kim loại?</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Niềng mắc cài kim loại phù hợp với hầu hết mọi đối tượng, đặc biệt hiệu quả trong các trường hợp sau:</p>
			</div>

			<div class="service-suited-list">
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Răng chen chúc, mọc lệch, mọc ngầm
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Hô (vẩu) — hàm trên nhô ra trước
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Móm — hàm dưới nhô ra trước
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Khớp cắn hở, khớp cắn chéo, khớp cắn sâu
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Răng thưa, hở kẽ răng nhiều
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Trẻ em từ 12 tuổi & người trưởng thành mọi lứa tuổi
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Ưu tiên hiệu quả điều trị hơn thẩm mỹ khi niềng
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Mong muốn chi phí hợp lý, tối ưu ngân sách
				</div>
			</div>
		</section>

		<!-- ══ Section: Quy trình điều trị ════════════════════ -->
		<section class="service-content-section reveal" id="quy-trinh">
			<h2 class="service-section-heading">Quy trình niềng mắc cài kim loại tại Pi Dentist</h2>
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
						<p class="service-step__title">Chuẩn bị & Gắn mắc cài</p>
						<p class="service-step__desc">Vệ sinh răng miệng, điều trị bệnh lý nền nếu có (sâu răng, viêm nướu). Gắn mắc cài kim loại lên từng răng theo vị trí đã tính toán.</p>
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
						<p class="service-step__desc">Tháo mắc cài, đánh bóng răng, lắp hàm duy trì (retainer) để cố định kết quả. Bác sĩ hẹn tái khám định kỳ 3-6 tháng để theo dõi lâu dài.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: So sánh phương pháp ═══════════════════ -->
		<section class="service-content-section reveal" id="so-sanh">
			<h2 class="service-section-heading">So sánh với các phương pháp niềng khác</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Bảng so sánh nhanh giúp bạn hiểu rõ sự khác biệt giữa niềng mắc cài kim loại và các phương pháp chỉnh nha phổ biến khác:</p>
			</div>

			<div class="service-comparison-table-wrap">
				<table class="service-comparison-table">
					<thead>
						<tr>
							<th>Tiêu chí</th>
							<th class="highlight-col">Mắc cài kim loại</th>
							<th>Mắc cài sứ</th>
							<th>Niềng trong suốt</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Hiệu quả điều trị</td>
							<td class="highlight-col"><strong>★★★★★</strong></td>
							<td>★★★★☆</td>
							<td>★★★★☆</td>
						</tr>
						<tr>
							<td>Thẩm mỹ khi đeo</td>
							<td class="highlight-col">★★☆☆☆</td>
							<td>★★★★☆</td>
							<td><strong>★★★★★</strong></td>
						</tr>
						<tr>
							<td>Chi phí</td>
							<td class="highlight-col"><strong>Từ 25 triệu</strong></td>
							<td>Từ 35 triệu</td>
							<td>Từ 50 triệu</td>
						</tr>
						<tr>
							<td>Thời gian điều trị</td>
							<td class="highlight-col">18-30 tháng</td>
							<td>18-30 tháng</td>
							<td>12-24 tháng</td>
						</tr>
						<tr>
							<td>Xử lý ca phức tạp</td>
							<td class="highlight-col"><strong>Rất tốt</strong></td>
							<td>Tốt</td>
							<td>Hạn chế</td>
						</tr>
						<tr>
							<td>Độ bền mắc cài</td>
							<td class="highlight-col"><strong>Rất cao</strong></td>
							<td>Trung bình</td>
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
